<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\PreciosModel;
use App\Models\ZonasModel;
use App\Models\TipoEnvioModel;

class PrecioController extends Controller
{
    public function index()
    {

        $precios = PreciosModel::with([
            'zonaOrigen',
            'zonaDestino'
        ])
        ->orderBy('id_precio','desc')
        ->paginate(10);

        $zonas = ZonasModel::all();

        $tipos = TipoEnvioModel::all();

        $data = [
            'url' => 'precios'
        ];

        return view(
            'admin.precios',
            compact(
                'precios',
                'zonas',
                'tipos',
                'data'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'id_zona_origen' => 'required',

            'id_zona_dest' => 'required',

            'peso_base' => 'required',

            'peso_tope' => 'required',

            'alto_base' => 'required',

            'alto_tope' => 'required',

            'ancho_base' => 'required',

            'ancho_tope' => 'required',

            'largo_base' => 'required',

            'largo_tope' => 'required',

            'moneda' => 'required',

            'tipo_envio' => 'required',

            'monto' => 'required'

        ]);

        PreciosModel::create([

            'id_zona_origen' =>
                $request->id_zona_origen,

            'id_zona_dest' =>
                $request->id_zona_dest,

            'peso_base' =>
                $request->peso_base,

            'peso_tope' =>
                $request->peso_tope,

            'alto_base' =>
                $request->alto_base,

            'alto_tope' =>
                $request->alto_tope,

            'ancho_base' =>
                $request->ancho_base,

            'ancho_tope' =>
                $request->ancho_tope,

            'largo_base' =>
                $request->largo_base,

            'largo_tope' =>
                $request->largo_tope,

            'moneda' =>
                $request->moneda,

            'tipo_envio' =>
                $request->tipo_envio,

            'monto' =>
                $request->monto,

            'created_at' => now(),

            'updated_at' => now()

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Tarifa registrada correctamente'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {

        $precio = PreciosModel::findOrFail($id);

        $precio->update([

            'id_zona_origen' =>
                $request->id_zona_origen,

            'id_zona_dest' =>
                $request->id_zona_dest,

            'peso_base' =>
                $request->peso_base,

            'peso_tope' =>
                $request->peso_tope,

            'alto_base' =>
                $request->alto_base,

            'alto_tope' =>
                $request->alto_tope,

            'ancho_base' =>
                $request->ancho_base,

            'ancho_tope' =>
                $request->ancho_tope,

            'largo_base' =>
                $request->largo_base,

            'largo_tope' =>
                $request->largo_tope,

            'moneda' =>
                $request->moneda,

            'tipo_envio' =>
                $request->tipo_envio,

            'monto' =>
                $request->monto,

            'updated_at' => now()

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Tarifa actualizada correctamente'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $precio = PreciosModel::findOrFail($id);

        $precio->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Tarifa eliminada correctamente'
            );

    }


    public function obtenerPrecio(Request $request)
    {
        $precio = PreciosModel::tarifa(

            $request->origen,
            $request->destino,

            $request->peso,

            $request->alto,
            $request->ancho,
            $request->largo,

            $request->tipo_envio

        )->first();



        if(!$precio){

            return response()->json([
                'success' => false,
                'mensaje' => 'No existe tarifa'
            ]);

        }

        return response()->json([
            'success' => true,
            'monto' => $precio->monto
        ]);
    }
   
}