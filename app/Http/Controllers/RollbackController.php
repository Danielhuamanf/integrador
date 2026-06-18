<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class RollbackController extends Controller
{
    public function rollback(Request $request)
    {
        // 1. Validar Token de Seguridad
        $token = $request->header('X-API-Key');
        if ($token !== config('audit.api_key', 'tu-clave-secreta')) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 401);
        }

        $request->validate([
            'tabla'       => 'required|string',
            'id_registro' => 'required',
            'datos'       => 'required|array'
        ]);

        $tabla      = $request->input('tabla');
        $idRegistro = $request->input('id_registro');
        $datos      = $request->input('datos');

        // 2. DESACTIVAR AUDITORÍA durante esta petición HTTP
        config(['audit.skip' => true]);

        try {
            if (!Schema::hasTable($tabla)) {
                return response()->json([
                    'success' => false,
                    'message' => "La tabla '{$tabla}' no existe en la base de datos."
                ], 400);
            }

            // Filtrar columnas para evitar insertar campos que ya no existan en la tabla actual
            $columnas = Schema::getColumnListing($tabla);
            $datosLimpios = array_intersect_key($datos, array_flip($columnas));

            // Quitar la clave primaria para que no cause conflictos al actualizar
            $primaryKey = 'id'; 
            unset($datosLimpios[$primaryKey]);

            // 3. Ejecutar la Restauración
            $existe = DB::table($tabla)->where($primaryKey, $idRegistro)->exists();

            if ($existe) {
                // Si el registro existe, lo actualizamos con los datos anteriores
                DB::table($tabla)->where($primaryKey, $idRegistro)->update($datosLimpios);
            } else {
                // Si el registro fue eliminado (DELETE) y hacemos rollback, lo volvemos a insertar con su ID
                $datosLimpios[$primaryKey] = $idRegistro;
                DB::table($tabla)->insert($datosLimpios);
            }

            return response()->json([
                'success' => true,
                'message' => 'Rollback aplicado exitosamente.'
            ]);

        } catch (\Exception $e) {
            Log::error("Error en rollback de tabla {$tabla} ID {$idRegistro}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar rollback en Laravel: ' . $e->getMessage()
            ], 500);
        }
    }
}