<?php

namespace App\Services;

use App\Models\IncidenciaModel;
use App\Models\UsuarioModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RuntimeException;

class IncidenciaCorreoImporter
{
    public function importar(): int
    {
        if (! function_exists('imap_open')) {
            throw new RuntimeException('La extension IMAP de PHP no esta habilitada.');
        }

        $mailbox = config('services.soporte.mailbox');
        $username = config('services.soporte.username');
        $password = config('services.soporte.password');

        if (! $mailbox || ! $username || ! $password) {
            throw new RuntimeException('Falta configurar SOPORTE_MAILBOX, SOPORTE_MAIL_USERNAME o SOPORTE_MAIL_PASSWORD.');
        }

        $conexion = @imap_open($mailbox, $username, $password);

        if (! $conexion) {
            throw new RuntimeException('No se pudo abrir el buzon de soporte: ' . imap_last_error());
        }

        $dias = (int) (config('services.soporte.dias_importar') ?: 5);
        $desde = Carbon::now()->subDays($dias)->format('d-M-Y');

        // Filtramos directamente en el servidor IMAP por fecha, asi los
        // correos antiguos (2019, etc.) ni siquiera se descargan.
        $mensajes = imap_search($conexion, 'UNSEEN SINCE "' . $desde . '"') ?: [];

        // imap_search devuelve los numeros de mensaje en el orden del buzon
        // (normalmente ascendente = mas antiguos primero). Los ordenamos por
        // fecha real y de mas reciente a mas antiguo antes de procesarlos.
        $candidatos = [];
        foreach ($mensajes as $numeroMensaje) {
            $overview = imap_fetch_overview($conexion, (string) $numeroMensaje, 0)[0] ?? null;

            if (! $overview) {
                continue;
            }

            $candidatos[] = [
                'numero' => $numeroMensaje,
                'overview' => $overview,
                'fecha' => $this->fechaRecepcion($overview->date ?? null),
            ];
        }

        usort($candidatos, fn ($a, $b) => $b['fecha'] <=> $a['fecha']);

        $importadas = 0;

        foreach ($candidatos as $candidato) {
            $numeroMensaje = $candidato['numero'];
            $overview = $candidato['overview'];

            $messageId = $overview->message_id ?? ('sin-id-' . $numeroMensaje . '-' . ($overview->date ?? now()));

            if (IncidenciaModel::where('correo_message_id', $messageId)->exists()) {
                continue;
            }

            $remitente = $this->obtenerRemitente($overview->from ?? '');
            $correo = $this->obtenerCorreo($overview->from ?? '');
            $asunto = $this->decodificar($overview->subject ?? 'Sin asunto');
            $cuerpo = $this->obtenerCuerpo($conexion, $numeroMensaje);
            $usuario = $correo ? UsuarioModel::where('correo', $correo)->first() : null;

            IncidenciaModel::create([
                'codigo' => IncidenciaModel::generarCodigo(),
                'titulo' => Str::limit($asunto, 195),
                'descripcion' => $this->truncarDescripcion($cuerpo),
                'prioridad' => 'media',
                'estado' => 'pendiente',
                'remitente' => $remitente ?: $correo,
                'correo_remitente' => $correo,
                'asunto_correo' => Str::limit($asunto, 195),
                'fecha_recepcion' => $candidato['fecha'],
                'origen' => 'correo',
                'correo_message_id' => $messageId,
                'id_usuario_creador' => $usuario?->id_usuario,
            ]);

            if (filter_var(config('services.soporte.marcar_leido'), FILTER_VALIDATE_BOOLEAN)) {
                imap_setflag_full($conexion, (string) $numeroMensaje, '\\Seen');
            }

            $importadas++;
        }

        imap_close($conexion);

        return $importadas;
    }

    /**
     * La columna `descripcion` es TEXT (65,535 bytes maximo en MySQL).
     * Algunos correos (boletines, promociones) traen HTML enorme que supera
     * ese limite y provocaba el error "Data too long for column
     * 'descripcion'". Cortamos de forma segura antes de guardar.
     */
    private function truncarDescripcion(string $cuerpo): string
    {
        $limite = 60000; // margen de seguridad bajo el limite de 65535 de TEXT

        if (mb_strlen($cuerpo) <= $limite) {
            return $cuerpo;
        }

        return mb_substr($cuerpo, 0, $limite) . "\n\n[... contenido truncado ...]";
    }

    private function obtenerCuerpo($conexion, int $numeroMensaje): string
    {
        $estructura = imap_fetchstructure($conexion, $numeroMensaje);

        if (! empty($estructura->parts)) {
            $encontradas = [];
            $this->recolectarPartes($conexion, $numeroMensaje, $estructura->parts, '', $encontradas);

            // Preferimos texto plano (mas limpio, sin CSS/HTML de boletines)
            // y solo recurrimos al HTML si no hay texto plano disponible.
            if (isset($encontradas['plain']) && $encontradas['plain'] !== '') {
                return $encontradas['plain'];
            }

            if (isset($encontradas['html']) && $encontradas['html'] !== '') {
                return $encontradas['html'];
            }
        }

        // Mensaje simple (sin multipart): decodificamos segun la codificacion
        // indicada en la estructura, en vez de asumir texto plano sin mas.
        $contenido = (string) imap_body($conexion, $numeroMensaje);

        return trim($this->decodificarContenido(
            $contenido,
            $estructura->encoding ?? 0,
            strtoupper($estructura->subtype ?? 'PLAIN'),
            $this->obtenerCharset($estructura)
        ));
    }

    /**
     * Recorre recursivamente la estructura MIME (multipart/alternative o
     * multipart/mixed pueden venir anidados dentro de otro multipart, por
     * ejemplo cuando el correo trae adjuntos). Sin esta recursion, el codigo
     * original no encontraba ninguna parte PLAIN/HTML en el primer nivel y
     * terminaba volcando el cuerpo crudo (sin decodificar quoted-printable)
     * directamente en la base de datos.
     */
    private function recolectarPartes($conexion, int $numeroMensaje, array $partes, string $prefijo, array &$encontradas): void
    {
        foreach ($partes as $indice => $parte) {
            $seccion = $prefijo !== '' ? $prefijo . '.' . ($indice + 1) : (string) ($indice + 1);

            if (! empty($parte->parts)) {
                $this->recolectarPartes($conexion, $numeroMensaje, $parte->parts, $seccion, $encontradas);
                continue;
            }

            $subtipo = strtoupper($parte->subtype ?? '');

            if ($subtipo !== 'PLAIN' && $subtipo !== 'HTML') {
                continue;
            }

            $clave = $subtipo === 'PLAIN' ? 'plain' : 'html';

            if (isset($encontradas[$clave])) {
                continue;
            }

            $contenido = imap_fetchbody($conexion, $numeroMensaje, $seccion);
            $encontradas[$clave] = $this->decodificarContenido(
                $contenido,
                $parte->encoding ?? 0,
                $subtipo,
                $this->obtenerCharset($parte)
            );
        }
    }

    /**
     * Busca el parametro CHARSET dentro de los parametros de la parte MIME
     * (imap_fetchstructure los expone en ->parameters y/o ->ifparameters).
     * Si no se especifica, ISO-8859-1 es el valor por defecto segun RFC 2045.
     */
    private function obtenerCharset(object $parte): string
    {
        $listas = [];

        if (! empty($parte->parameters)) {
            $listas[] = $parte->parameters;
        }

        if (! empty($parte->dparameters)) {
            $listas[] = $parte->dparameters;
        }

        foreach ($listas as $parametros) {
            foreach ($parametros as $parametro) {
                if (strtoupper($parametro->attribute ?? '') === 'CHARSET') {
                    return strtoupper(trim($parametro->value ?? 'ISO-8859-1'));
                }
            }
        }

        return 'ISO-8859-1';
    }

    private function decodificarContenido(string $contenido, int $codificacion, string $subtipo, string $charset = 'ISO-8859-1'): string
    {
        if ($codificacion === 3) {
            $contenido = base64_decode($contenido) ?: '';
        } elseif ($codificacion === 4) {
            $contenido = quoted_printable_decode($contenido);
        }

        // Convertimos a UTF-8 segun el charset real del correo. Sin esto,
        // correos en ISO-8859-1/Windows-1252 (muy comunes en boletines
        // comerciales) generan bytes invalidos para una columna utf8/utf8mb4
        // y MySQL rechaza el insert con "Incorrect string value".
        $contenido = $this->convertirAUtf8($contenido, $charset);

        if ($subtipo === 'HTML') {
            $contenido = preg_replace('/<(style|script)\b[^>]*>.*?<\/\1>/is', '', $contenido) ?? $contenido;
            $contenido = preg_replace('/<br\s*\/?>|<\/(p|div|tr)>/i', "\n", $contenido) ?? $contenido;
            $contenido = strip_tags($contenido);
        }

        $contenido = html_entity_decode($contenido, ENT_QUOTES | ENT_HTML5);

        // Colapsamos espacios/lineas en blanco excesivas que suelen quedar
        // tras limpiar plantillas HTML de boletines.
        $contenido = preg_replace("/[ \t]+/", ' ', $contenido) ?? $contenido;
        $contenido = preg_replace("/\n{3,}/", "\n\n", $contenido) ?? $contenido;

        return trim($contenido);
    }

    private function convertirAUtf8(string $contenido, string $charset): string
    {
        if ($contenido === '') {
            return $contenido;
        }

        $charset = $charset === '' ? 'ISO-8859-1' : $charset;

        // UTF-8/US-ASCII: si ya es UTF-8 valido, no tocamos nada.
        if (in_array($charset, ['UTF-8', 'US-ASCII', 'ASCII'], true) && mb_check_encoding($contenido, 'UTF-8')) {
            return $contenido;
        }

        $convertido = @iconv($charset, 'UTF-8//IGNORE', $contenido);

        if ($convertido !== false && $convertido !== null) {
            return $convertido;
        }

        // Si iconv no reconoce el charset declarado (algunos correos ponen
        // valores raros), intentamos con mb_convert_encoding y, si todo
        // falla, forzamos limpieza de bytes invalidos como ultimo recurso.
        $convertido = @mb_convert_encoding($contenido, 'UTF-8', $charset);

        if ($convertido !== false && $convertido !== '') {
            return $convertido;
        }

        return mb_convert_encoding($contenido, 'UTF-8', 'ISO-8859-1');
    }

    private function obtenerCorreo(string $from): ?string
    {
        if (preg_match('/<([^>]+)>/', $from, $matches)) {
            return Str::lower(trim($matches[1]));
        }

        if (filter_var(trim($from), FILTER_VALIDATE_EMAIL)) {
            return Str::lower(trim($from));
        }

        return null;
    }

    private function obtenerRemitente(string $from): ?string
    {
        $limpio = preg_replace('/<[^>]+>/', '', $from);
        $limpio = trim($this->decodificar((string) $limpio), "\"' ");

        return $limpio !== '' ? $limpio : null;
    }

    private function decodificar(string $texto): string
    {
        $partes = imap_mime_header_decode($texto);
        $resultado = '';

        foreach ($partes as $parte) {
            $fragmento = $parte->text ?? '';
            $charset = strtoupper($parte->charset ?? 'default');

            // imap_mime_header_decode devuelve 'default' cuando el fragmento
            // no estaba codificado (=?charset?..?..?=); en ese caso ya viene
            // en ASCII/UTF-8 y no hay que convertir.
            if ($charset !== 'DEFAULT') {
                $fragmento = $this->convertirAUtf8($fragmento, $charset);
            }

            $resultado .= $fragmento;
        }

        return trim($resultado);
    }

    private function fechaRecepcion(?string $fecha): Carbon
    {
        try {
            return $fecha ? Carbon::parse($fecha) : now();
        } catch (\Throwable) {
            return now();
        }
    }
}