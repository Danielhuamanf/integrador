<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\EnvioDetalleModel;
use App\Models\EnvioModel;
use App\Models\ClienteModel;

class VentaController extends Controller
{
   public function index()
    {

        $ventas = EnvioModel::all();
        return view('admin.order_list', compact('ventas'));
    }
    public function agregar_venta()
    {
        $ventas = EnvioModel::all();
        return view('admin.add_venta', compact('ventas'));
    }
    public function store(Request $request)
    {

        $request->validate([

            // CLIENTE
            'cliente' => 'required',
            'correo' => 'required',
            'documento' => 'required',
            'telefono' => 'required',

            // ENVIO
            'zona_origen' => 'required',
            'zona_destino' => 'required',
            'peso' => 'required',
            'alto' => 'required',
            'ancho' => 'required',
            'largo' => 'required',
            'descripcion' => 'required',

        ]);


        $voucher = null;

        if($request->hasFile('voucher')){

            $voucher = $request->file('voucher')
                ->store('vouchers', 'public');

        }

        $envio = EnvioModel::create([

            'cliente' => $request->cliente,
            'correo' => $request->correo,
            'documento' => $request->documento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,

            'estado' => 'Pendiente',

            'fecha' => now(),

            'total' => $request->total,

            'voucher' => $voucher,

        ]);


        EnvioDetalle::create([

            'id_envio' => $envio->id_envio,

            'zona_origen' => $request->zona_origen,

            'zona_destino' => $request->zona_destino,

            'peso' => $request->peso,

            'alto' => $request->alto,

            'ancho' => $request->ancho,

            'largo' => $request->largo,

            'tipo_envio' => $request->tipo_envio,

            'categoria' => $request->categoria,

            'descripcion' => $request->descripcion,

        ]);


        return redirect()
            ->route('ventas.show', $envio->id_envio)
            ->with('success', 'Venta registrada');

    }
    public function show($id)
    {

        $venta = Envio::with('detalle')
            ->where('id_envio', $id)
            ->firstOrFail();

        return view('ventas.show', compact('venta'));

    }
    public function buscarCliente(Request $request)
    {

        $buscar = $request->buscar;

        $cliente = ClienteModel::where('dni', $buscar)
            ->orWhere('ruc', $buscar)
            ->orWhere('nombre_completo', 'LIKE', "%$buscar%")
            ->first();

        if($cliente){

            return response()->json([
                'success' => true,
                'cliente' => $cliente
            ]);

        }

        return response()->json([
            'success' => false
        ]);

    }

  

    // ELIMINAR
    public function destroy($id)
    {
        
    }
}