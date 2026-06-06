<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait Auditable
{
    /**
     * Boot del Trait. Laravel lo ejecuta automáticamente al inicializar el Modelo.
     */
    public static function bootAuditable()
    {
        // Evento: Registro Creado
        static::created(function ($model) {
            static::enviarAuditoria($model, 'INSERT', [], $model->getAttributes());
        });

        // Evento: Registro Modificado
        static::updated(function ($model) {
            $antes = [];
            $despues = [];

            // Capturar solo los campos que cambiaron
            foreach ($model->getChanges() as $campo => $nuevoValor) {
                // Opcional: ignorar marcas de tiempo por defecto si no deseas auditarlas
                if (in_array($campo, ['updated_at'])) {
                    continue;
                }
                $antes[$campo] = $model->getOriginal($campo);
                $despues[$campo] = $nuevoValor;
            }

            if (!empty($despues)) {
                static::enviarAuditoria($model, 'UPDATE', $antes, $despues);
            }
        });

        // Evento: Registro Eliminado
        static::deleted(function ($model) {
            static::enviarAuditoria($model, 'DELETE', $model->getOriginal(), []);
        });
    }

    /**
     * Envía la petición HTTP POST a CodeIgniter.
     */
    protected static function enviarAuditoria($model, $accion, $antes, $despues)
    {
        // Evitar bucle infinito si el cambio proviene de un ROLLBACK
        if (config('audit.skip', false)) {
            return;
        }

        $usuario = Auth::user();

        $payload = [
            'sistema'     => 'LARAVEL',
            'tabla'       => $model->getTable(),
            'id_registro' => $model->getKey(),
            'accion'      => $accion,
            'usuario'     => [
                'id'     => $usuario ? $usuario->getKey() : null,
                'nombre' => $usuario ? ($usuario->name ?? $usuario->email ?? $usuario->username) : 'Sistema/Script'
            ],
            'antes'       => $antes,
            'despues'     => $despues
        ];

        try {
            // NOTA: Para producción es muy recomendable mover esto a un Job en segundo plano (Queue)
            Http::withHeaders([
                'X-API-Key' => config('audit.api_key', 'tu-clave-secreta') // Token de seguridad
            ])->timeout(3)
              ->post(config('audit.ci_url', 'http://localhost/observador/public/auditoria/registrar'), $payload);
        } catch (\Exception $e) {
            Log::error('Error al registrar auditoría en CodeIgniter: ' . $e->getMessage());
        }
    }
}