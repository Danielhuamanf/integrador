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

                $eventos[] = [

                    'fecha' => trim($match[1]),

                    'canal' => trim($match[2]),

                    'nivel' => strtoupper(trim($match[3])),

                    'mensaje' => trim($match[4])

                ];

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
        | CONTINÚA EN LA PARTE 2
        |--------------------------------------------------------------------------
        */
          /*
        |--------------------------------------------------------------------------
        | FILTROS
        |--------------------------------------------------------------------------
        */

        $buscar = trim($request->get('buscar', ''));

        $nivel = strtoupper(trim($request->get('nivel', '')));

        $fecha = trim($request->get('fecha', ''));

        $eventos = collect($eventos)->filter(function ($evento) use ($buscar, $nivel, $fecha) {

            // Buscar texto
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

            // Filtrar por nivel
            if ($nivel != '' && $evento['nivel'] != $nivel) {
                return false;
            }

            // Filtrar por fecha
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


}