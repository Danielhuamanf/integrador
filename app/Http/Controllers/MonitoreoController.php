<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoreoController extends Controller
{

    public function index(Request $request)
    {

        $archivo = storage_path('logs/laravel.log');

        $eventos = [];

        if (File::exists($archivo)) {

            $contenido = File::get($archivo);

            /*
            |--------------------------------------------------------------------------
            | Cada evento comienza con:
            | [2026-07-03 20:00:00] local.INFO:
            |--------------------------------------------------------------------------
            */

            preg_match_all(
                '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]\s+(\w+)\.(INFO|WARNING|ERROR|DEBUG|NOTICE|CRITICAL|ALERT|EMERGENCY)\:(.*?)(?=^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|\z)/ms',
                $contenido,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
<<<<<<< HEAD
                $mensaje = trim($match[4]);
                $nivel = strtoupper(trim($match[3]));
                $nivelInfo = $this->nivelEstandar($nivel);

                $eventos[] = [
                    'fecha' => trim($match[1]),
                    'canal' => trim($match[2]),
                    'nivel' => $nivel,
                    'nivel_nombre' => $nivelInfo['nombre'],
                    'nivel_desc' => $nivelInfo['desc'],
                    'gravedad' => $nivelInfo['gravedad'],
                    'mensaje' => $mensaje,
                    'descripcion' => $this->describirEvento($mensaje, $nivel),
                    'solucion' => $this->sugerirSolucion($mensaje, $nivel),
                ];
=======

                $eventos[] = [

                    'fecha' => trim($match[1]),

                    'canal' => trim($match[2]),

                    'nivel' => strtoupper(trim($match[3])),

                    'mensaje' => trim($match[4])

                ];

>>>>>>> dev
            }

        }

        /*
        |--------------------------------------------------------------------------
        | Ordenar del más reciente al más antiguo
        |--------------------------------------------------------------------------
        */

        $eventos = array_reverse($eventos);

        /*
        |--------------------------------------------------------------------------
<<<<<<< HEAD
=======
        | CONTINÚA EN LA PARTE 2
        |--------------------------------------------------------------------------
        */
          /*
        |--------------------------------------------------------------------------
>>>>>>> dev
        | FILTROS
        |--------------------------------------------------------------------------
        */

        $buscar = trim($request->get('buscar', ''));

        $nivel = strtoupper(trim($request->get('nivel', '')));

        $fecha = trim($request->get('fecha', ''));

        $eventos = collect($eventos)->filter(function ($evento) use ($buscar, $nivel, $fecha) {

<<<<<<< HEAD
=======
            // Buscar texto
>>>>>>> dev
            if ($buscar != '') {

                $texto = strtolower(
                    $evento['mensaje'] .
                    ' ' .
                    $evento['nivel'] .
                    ' ' .
                    $evento['fecha']
                );

                if (!str_contains($texto, strtolower($buscar))) {
                    return false;
                }
            }

<<<<<<< HEAD
=======
            // Filtrar por nivel
>>>>>>> dev
            if ($nivel != '' && $evento['nivel'] != $nivel) {
                return false;
            }

<<<<<<< HEAD
=======
            // Filtrar por fecha
>>>>>>> dev
            if ($fecha != '' && !str_contains($evento['fecha'], $fecha)) {
                return false;
            }

            return true;

        })->values();

        /*
        |--------------------------------------------------------------------------
        | ESTADISTICAS (antes de paginar)
        |--------------------------------------------------------------------------
        */

        $estadisticas = [

            'total' => $eventos->count(),

            'info' => $eventos->where('nivel', 'INFO')->count(),

            'warning' => $eventos->where('nivel', 'WARNING')->count(),

            'error' => $eventos->where('nivel', 'ERROR')->count(),

            'critical' => $eventos->where('nivel', 'CRITICAL')->count(),

            'debug' => $eventos->where('nivel', 'DEBUG')->count(),

        ];

        /*
        |--------------------------------------------------------------------------
        | PAGINACION
        |--------------------------------------------------------------------------
        */

        $porPagina = 50;

        $pagina = LengthAwarePaginator::resolveCurrentPage();

        $items = $eventos->slice(
            ($pagina - 1) * $porPagina,
            $porPagina
        )->values();

        $eventos = new LengthAwarePaginator(

            $items,

            $eventos->count(),

            $porPagina,

            $pagina,

            [

                'path' => request()->url(),

                'query' => request()->query()

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        $data = ['url' => 'monitoreo'];

        return view(
            'monitoreo',
            compact(
                'eventos',
                'estadisticas',
                'data'
            )
        );

    }

<<<<<<< HEAD
    private function nivelEstandar(string $nivel): array
    {
        $mapa = [
            'EMERGENCY' => ['label' => 'EMERGENCY', 'nombre' => 'Emergencia',     'desc' => 'Toda la aplicación está inutilizable.',              'gravedad' => 8],
            'ALERT'     => ['label' => 'ALERT',     'nombre' => 'Alerta',          'desc' => 'Se necesita intervención inmediata.',              'gravedad' => 7],
            'CRITICAL'  => ['label' => 'CRITICAL',  'nombre' => 'Crítico',         'desc' => 'Error crítico que afecta una parte esencial.',     'gravedad' => 6],
            'ERROR'     => ['label' => 'ERROR',     'nombre' => 'Error',           'desc' => 'Error importante, pero la app sigue funcionando.', 'gravedad' => 5],
            'WARNING'   => ['label' => 'WARNING',   'nombre' => 'Advertencia',     'desc' => 'Situación anormal que podría convertirse en problema.','gravedad'=> 4],
            'NOTICE'    => ['label' => 'NOTICE',    'nombre' => 'Aviso',           'desc' => 'Evento relevante, pero esperado.',                'gravedad' => 3],
            'INFO'      => ['label' => 'INFO',      'nombre' => 'Informativo',     'desc' => 'Información del funcionamiento normal.',          'gravedad' => 2],
            'DEBUG'     => ['label' => 'DEBUG',     'nombre' => 'Depuración',      'desc' => 'Información para desarrolladores.',               'gravedad' => 1],
        ];
        return $mapa[$nivel] ?? ['label' => $nivel, 'nombre' => ucfirst(strtolower($nivel)), 'desc' => '', 'gravedad' => 0];
    }

    private function sugerirSolucion(string $mensaje, string $nivel): array
    {
        $m = strtolower($mensaje);

        $base = [
            'solucion' => '',
            'acciones' => [],
        ];

        if (str_contains($m, 'controller') && (str_contains($m, 'not found') || str_contains($m, 'does not exist'))) {
            $base['solucion'] = 'El controlador referenciado no existe. Revisá que la clase esté creada en app/Http/Controllers/ y que el namespace sea correcto.';
            $base['acciones'] = [
                'Crear el archivo del controlador faltante en app/Http/Controllers/',
                'Verificar que el nombre de la clase coincida con el nombre del archivo',
                'Si el controlador fue eliminado intencionalmente, actualizar la ruta que lo referencia',
                'Ejecutar "composer dump-autoload" para regenerar el autoload',
            ];
            return $base;
        }

        if (str_contains($m, 'sqlstate') || str_contains($m, 'sql') || str_contains($m, 'base de datos')) {
            if (str_contains($m, 'duplicate entry')) {
                $base['solucion'] = 'Se intentó insertar un registro con un valor duplicado en una columna única. Verificá los datos antes de insertar.';
                $base['acciones'] = [
                    'Revisar si el registro ya existe en la base de datos',
                    'Agregar validación de unicidad antes de insertar',
                    'Si es esperado, capturar la excepción con un try-catch',
                ];
                return $base;
            }
            if (str_contains($m, 'connection refused') || str_contains($m, 'no se pudo conectar')) {
                $base['solucion'] = 'La aplicación no puede conectarse a la base de datos. Verificá que el servidor MySQL esté en ejecución.';
                $base['acciones'] = [
                    'Ejecutar "net start MySQL" o iniciar el servicio desde Servicios de Windows',
                    'Verificar las credenciales en .env (DB_HOST, DB_PORT, DB_DATABASE, etc.)',
                    'Probar conexión con "php artisan db:show"',
                    'Revisar que el puerto 3306 esté abierto y no bloqueado por un firewall',
                ];
                return $base;
            }
            if (str_contains($m, 'table') && (str_contains($m, 'not found') || str_contains($m, "doesn't exist"))) {
                $base['solucion'] = 'Una tabla referenciada no existe en la base de datos. Puede faltar una migración.';
                $base['acciones'] = [
                    'Ejecutar "php artisan migrate" para correr las migraciones pendientes',
                    'Si la migración ya se ejecutó, verificar que la tabla esté creada en la BD',
                    'Revisar el nombre de la tabla en el modelo (propiedad $table)',
                ];
                return $base;
            }
            $base['solucion'] = 'Ocurrió un error en la base de datos. Revisá el mensaje completo para más detalles.';
            $base['acciones'] = [
                'Revisar el log completo para identificar la consulta problemática',
                'Activar el log de consultas lentas en MySQL',
                'Ejecutar "php artisan db:show" para verificar el estado de la BD',
            ];
            return $base;
        }

        if (str_contains($m, 'route') && str_contains($m, 'not defined') || str_contains($m, 'route') && str_contains($m, 'not found')) {
            $base['solucion'] = 'Una ruta no está definida en routes/web.php o el nombre no coincide.';
            $base['acciones'] = [
                'Verificar que la ruta exista en routes/web.php',
                'Si usás route("nombre"), confirmá que tenga ->name("nombre")',
                'Ejecutar "php artisan route:list" para ver todas las rutas disponibles',
                'Limpiar caché de rutas: "php artisan route:clear"',
            ];
            return $base;
        }

        if (str_contains($m, 'method') && str_contains($m, 'not exist') || str_contains($m, 'undefined method') || str_contains($m, 'call to undefined')) {
            $base['solucion'] = 'Se está llamando a un método que no existe en la clase. Revisá que el método esté definido.';
            $base['acciones'] = [
                'Revisar el nombre del método en el código fuente',
                'Verificar que la clase importada use el trait correcto si el método viene de un trait',
                'Si es un método dinámico (__call), asegurarse de que el nombre sea válido',
            ];
            return $base;
        }

        if (str_contains($m, 'undefined variable') || str_contains($m, 'undefined index')) {
            $base['solucion'] = 'Se intentó acceder a una variable o índice de array que no fue definido.';
            $base['acciones'] = [
                'Revisar que la variable esté definida antes de usarla (isset() o ?? )',
                'Para arrays, usar $array["clave"] ?? null en lugar de $array["clave"]',
                'Verificar que los datos lleguen correctamente desde el formulario o la BD',
            ];
            return $base;
        }

        if (str_contains($m, 'trying to get property') || str_contains($m, 'null')) {
            $base['solucion'] = 'Se intentó acceder a una propiedad de un objeto que es null.';
            $base['acciones'] = [
                'Usar el operador de null seguro: $objeto?->propiedad',
                'Verificar que la consulta a la BD devuelva resultados antes de acceder',
                'Agregar validaciones con if ($objeto) antes de usar sus propiedades',
            ];
            return $base;
        }

        if (str_contains($m, 'division by zero')) {
            $base['solucion'] = 'Se intentó dividir un número entre cero.';
            $base['acciones'] = [
                'Validar que el divisor no sea cero antes de dividir',
                'Usar un valor por defecto: $divisor > 0 ? $a / $divisor : 0',
                'Revisar cálculos financieros o estadísticos que puedan dar cero',
            ];
            return $base;
        }

        if (str_contains($m, 'file_get_contents') || str_contains($m, 'failed to open') || str_contains($m, 'fopen')) {
            $base['solucion'] = 'La aplicación no pudo leer o escribir un archivo. Verificá permisos y rutas.';
            $base['acciones'] = [
                'Verificar que el archivo exista en la ruta especificada',
                'Dar permisos de lectura/escritura a la carpeta storage/ y public/',
                'Si es un archivo subido por el usuario, revisar que no exceda el tamaño máximo',
            ];
            return $base;
        }

        if (str_contains($m, 'permission denied') || str_contains($m, 'permiso denegado')) {
            $base['solucion'] = 'La aplicación no tiene permisos suficientes para acceder a un recurso.';
            $base['acciones'] = [
                'Dar permisos 775 o 755 a la carpeta storage/',
                'En Windows, verificar que la carpeta no esté marcada como "Solo lectura"',
                'Si es en Linux, ejecutar "chmod -R 775 storage/ bootstrap/cache/"',
                'Asegurar que el usuario del servidor web sea el dueño de los archivos',
            ];
            return $base;
        }

        if (str_contains($m, 'mail') || str_contains($m, 'correo') || str_contains($m, 'smtp') || str_contains($m, 'email')) {
            $base['solucion'] = 'Ocurrió un error al enviar un correo electrónico.';
            $base['acciones'] = [
                'Verificar la configuración SMTP en .env (MAIL_HOST, MAIL_PORT, etc.)',
                'Probar con Mail::raw() en php artisan tinker',
                'Si usás Gmail, verificar que la contraseña de aplicación sea correcta',
                'Revisar que el puerto SMTP no esté bloqueado por el firewall',
            ];
            return $base;
        }

        if (str_contains($m, 'timeout') || str_contains($m, 'tiempo de espera')) {
            $base['solucion'] = 'Una conexión externa excedió el tiempo de espera.';
            $base['acciones'] = [
                'Verificar que el servicio externo esté funcionando',
                'Aumentar el tiempo de espera en la configuración',
                'Implementar reintentos con backoff exponencial',
                'Agregar una cola de trabajos (jobs) para tareas pesadas',
            ];
            return $base;
        }

        if (str_contains($m, 'session') && (str_contains($m, 'expired') || str_contains($m, 'csrf'))) {
            $base['solucion'] = 'La sesión expiró o el token CSRF es inválido.';
            $base['acciones'] = [
                'Limpiar cookies del navegador o probar en una ventana de incógnito',
                'Aumentar el tiempo de vida de la sesión en config/session.php (lifetime)',
                'Si usás AJAX, incluir el token CSRF en el header X-CSRF-TOKEN',
                'Ejecutar "php artisan session:table" si usás sesiones en BD y migrar',
            ];
            return $base;
        }

        if ($nivel === 'CRITICAL' || $nivel === 'ALERT' || $nivel === 'EMERGENCY') {
            $base['solucion'] = 'Error crítico del sistema. Se requiere intervención inmediata.';
            $base['acciones'] = [
                'Revisar el mensaje completo para entender el origen del problema',
                'Verificar el estado del servidor y los servicios (MySQL, Apache, etc.)',
                'Revisar el uso de memoria y CPU del servidor',
                'Si es recurrente, implementar un sistema de monitoreo y alertas',
            ];
            return $base;
        }

        if ($nivel === 'WARNING') {
            $base['solucion'] = 'Advertencia del sistema. No es crítica pero conviene revisarla.';
            $base['acciones'] = [
                'Revisar si el patrón se repite para detectar tendencias',
                'Documentar la advertencia para referencia futura',
                'Si es esperada, considerar suprimirla o manejarla explícitamente',
            ];
            return $base;
        }

        if ($nivel === 'ERROR') {
            $base['solucion'] = 'Ocurrió un error que degradó la funcionalidad. Revisá el mensaje completo.';
            $base['acciones'] = [
                'Identificar el archivo y línea donde ocurre el error',
                'Revisar si es un error recurrente o aislado',
                'Agregar manejo de excepciones con try-catch si es necesario',
                'Monitorear si el error afecta a usuarios o solo a ciertas funciones',
            ];
            return $base;
        }

        $base['solucion'] = 'No hay una solución predefinida para este evento. Revisá el mensaje completo.';
        $base['acciones'] = [
            'Analizar el contexto del evento en el mensaje completo',
            'Buscar el error en los foros de Laravel o Stack Overflow',
            'Si es recurrente, considerar agregar una entrada en la base de conocimiento',
        ];

        return $base;
    }

    private function describirEvento(string $mensaje, string $nivel): string
    {
        $m = strtolower($mensaje);

        if (str_contains($m, 'auth') || str_contains($m, 'login') || str_contains($m, 'authentication')) {
            if (preg_match('/credenciales? incorrectas?|invalid credenti|failed.*auth|login failed/i', $m)) {
                return 'Inicio de sesión fallido — credenciales incorrectas';
            }
            if (preg_match('/sesión? inicid|logged in|login exitoso|authenticated successfully/i', $m)) {
                return 'Inicio de sesión exitoso';
            }
            if (preg_match('/sesión? cerrad?|logged out|logout/i', $m)) {
                return 'Cierre de sesión';
            }
            if (preg_match('/token|api.*key|sanctum/i', $m)) {
                return 'Error de autenticación por token';
            }
            return 'Evento de autenticación';
        }

        if (str_contains($m, 'sqlstate') || str_contains($m, 'sql') || str_contains($m, 'base de datos') || str_contains($m, 'database')) {
            if (str_contains($m, 'duplicate entry')) {
                return 'Error de base de datos — entrada duplicada';
            }
            if (str_contains($m, 'foreign key') || str_contains($m, 'constraint')) {
                return 'Error de base de datos — violación de clave foránea';
            }
            if (str_contains($m, 'not null') || str_contains($m, 'cannot be null')) {
                return 'Error de base de datos — valor nulo no permitido';
            }
            if (str_contains($m, 'connection refused') || str_contains($m, 'no se pudo conectar')) {
                return 'Error de conexión a la base de datos';
            }
            if (str_contains($m, 'syntax error') || str_contains($m, 'error de sintaxis')) {
                return 'Error de sintaxis SQL';
            }
            if (str_contains($m, 'table') && (str_contains($m, 'not found') || str_contains($m, "doesn't exist"))) {
                return 'Error — tabla de base de datos no encontrada';
            }
            if (str_contains($m, 'column') && (str_contains($m, 'not found') || str_contains($m, 'unknown'))) {
                return 'Error — columna no encontrada en la base de datos';
            }
            if (str_contains($m, 'lock') && str_contains($m, 'deadlock')) {
                return 'Error — deadlock en base de datos';
            }
            if (str_contains($m, 'query') && str_contains($m, 'max')) {
                return 'Advertencia — consulta lenta o tamaño máximo excedido';
            }
            if ($nivel === 'WARNING') {
                return 'Advertencia de base de datos';
            }
            return 'Error de base de datos';
        }

        if (str_contains($m, 'not found') || str_contains($m, 'route') || str_contains($m, '404')) {
            if (str_contains($m, 'route') && str_contains($m, 'not defined')) {
                return 'Error — ruta no definida';
            }
            if (str_contains($m, 'not found') || str_contains($m, '404')) {
                return 'Error 404 — recurso no encontrado';
            }
            return 'Error de ruteo';
        }

        if (str_contains($m, 'method') && (str_contains($m, 'not allowed') || str_contains($m, 'notsupported') || str_contains($m, 'not supported'))) {
            return 'Error — método HTTP no permitido';
        }
        if (str_contains($m, 'method') && str_contains($m, 'not exist') || str_contains($m, 'undefined method')) {
            return 'Error — método no implementado en la clase';
        }

        if (str_contains($m, 'class') || str_contains($m, 'interface') || str_contains($m, 'trait')) {
            if (str_contains($m, 'not found') || str_contains($m, 'does not exist')) {
                if (preg_match('/controller[\s\d]*does not exist/i', $m)) {
                    return 'Error — controlador no encontrado (Controller2)';
                }
                return 'Error — clase o archivo no encontrado';
            }
            return 'Error de carga de clase';
        }

        if (str_contains($m, 'undefined variable') || str_contains($m, 'undefined index') || str_contains($m, 'undefined offset')) {
            return 'Advertencia — variable o índice no definido';
        }
        if (str_contains($m, 'trying to get property') || str_contains($m, 'trying to access') || str_contains($m, 'null')) {
            if (str_contains($m, 'null')) {
                return 'Error — acceso a propiedad de un valor nulo';
            }
            return 'Error — acceso a propiedad inexistente';
        }
        if (str_contains($m, 'division by zero')) {
            return 'Error — división entre cero';
        }
        if (str_contains($m, 'call to undefined')) {
            return 'Error — llamada a función o método no definido';
        }
        if (str_contains($m, 'argument') && (str_contains($m, 'missing') || str_contains($m, 'required'))) {
            return 'Error — argumento faltante en función';
        }
        if (str_contains($m, 'typeerror') || str_contains($m, 'type error')) {
            return 'Error de tipo — tipo de dato incorrecto';
        }

        if (str_contains($m, 'file_get_contents') || str_contains($m, 'failed to open') || str_contains($m, 'fopen') || str_contains($m, 'file_put_contents')) {
            if (str_contains($m, 'stream') || str_contains($m, 'open')) {
                return 'Error — no se pudo abrir el archivo o stream';
            }
            return 'Error de lectura/escritura de archivo';
        }
        if (str_contains($m, 'mkdir') || str_contains($m, 'directory') || str_contains($m, 'permission denied') || str_contains($m, 'permiso')) {
            if (str_contains($m, 'permission denied') || str_contains($m, 'permiso denegado')) {
                return 'Error — permiso denegado';
            }
            return 'Error de directorio o permisos';
        }
        if (str_contains($m, 'disk') || str_contains($m, 'storage') || str_contains($m, 'upload')) {
            if (str_contains($m, 'full') || str_contains($m, 'space') || str_contains($m, 'no space')) {
                return 'Advertencia — espacio en disco insuficiente';
            }
            return 'Evento de almacenamiento';
        }

        if (str_contains($m, 'mail') || str_contains($m, 'email') || str_contains($m, 'correo') || str_contains($m, 'smtp')) {
            if (str_contains($m, 'failed') || str_contains($m, 'could not') || str_contains($m, 'connection')) {
                return 'Error — fallo en envío de correo';
            }
            return 'Evento de correo electrónico';
        }

        if (str_contains($m, 'curl') || str_contains($m, 'api') || str_contains($m, 'timeout') || str_contains($m, 'http code')) {
            if (str_contains($m, 'timeout')) {
                return 'Error — tiempo de espera agotado (timeout)';
            }
            if (str_contains($m, 'connection refused')) {
                return 'Error — conexión rechazada';
            }
            return 'Evento de API o conexión externa';
        }

        if (str_contains($m, 'session')) {
            if (str_contains($m, 'expired')) {
                return 'Sesión expirada';
            }
            if (str_contains($m, 'csrf') || str_contains($m, 'token mismatch')) {
                return 'Error — token CSRF inválido';
            }
            return 'Evento de sesión';
        }

        if (str_contains($m, 'queue') || str_contains($m, 'job') || str_contains($m, 'horizon')) {
            if (str_contains($m, 'failed') || str_contains($m, 'error')) {
                return 'Error — trabajo en cola fallido';
            }
            return 'Evento de cola/background job';
        }

        if ($nivel === 'DEBUG') {
            return 'Mensaje de depuración';
        }
        if ($nivel === 'INFO') {
            return 'Informativo';
        }
        if ($nivel === 'NOTICE') {
            return 'Aviso del sistema';
        }
        if ($nivel === 'WARNING') {
            return 'Advertencia del sistema';
        }
        if ($nivel === 'CRITICAL' || $nivel === 'ALERT' || $nivel === 'EMERGENCY') {
            return 'Evento crítico del sistema';
        }

        return 'Evento del sistema';
    }

}
=======

}
>>>>>>> dev
