<?php

namespace App\Observers;

use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Storage;

class UsuarioObserver
{
    public function created(Usuario $usuario): void
    {
        // Nombre del archivo
        $archivo = 'backup_tables/usuarios.json';

        // Obtener contenido actual
        $datos = [];

        if (Storage::exists($archivo)) {
            $contenido = Storage::get($archivo);
            $datos = json_decode($contenido, true) ?? [];
        }

        // Agregar nuevo registro
        $datos[] = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'correo' => $usuario->correo,
            'created_at' => now()->toDateTimeString()
        ];

        // Guardar nuevamente
        Storage::put(
            $archivo,
            json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}