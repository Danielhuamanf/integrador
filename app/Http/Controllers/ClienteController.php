<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\ClienteModel;
class ClienteController extends Controller
{
     public function home()
    {
        $clientes = ClienteModel::all();
         $data = ['url'=>'clientes'];
        return view('cliente.home_cliente', compact('clientes','data'));
    }
    public function envios_cliente()
    {
        $clientes = ClienteModel::all();
         $data = ['url'=>'clientes'];
        return view('cliente.envios_cliente', compact('clientes','data'));
    }
    public function ver_clientes()
    {
        $clientes = ClienteModel::all();
         $data = ['url'=>'clientes'];
        return view('admin.clientes', compact('clientes','data'));
    }
    // GUARDAR
   public function guardar_cliente(Request $request)
    {
        ClienteModel::create([

            'id_usuario' => 1, // luego puedes poner auth()->id()
            'tipo_persona' => $request->tipo_persona,
            'nombre_completo' => $request->nombre_completo,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ubigeo' => $request->ubigeo,
            'estado' => $request->estado,
            'ruc' => $request->ruc,
            'nombre_comercial' => $request->nombre_comercial,
            'representante_legal' => $request->representante_legal,
            'dni' => $request->dni
        ]);

        return redirect()->back()
            ->with('success','Cliente registrado');
    }
    public function editar_cliente(Request $request, $id)
    {
        $cliente = ClienteModel::find($id);

        if(!$cliente){
            return redirect()->back();
        }

        $cliente->update([

            'tipo_persona' => $request->tipo_persona,
            'nombre_completo' => $request->nombre_completo,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'ubigeo' => $request->ubigeo,
            'estado' => $request->estado,
            'ruc' => $request->ruc,
            'nombre_comercial' => $request->nombre_comercial,
            'representante_legal' => $request->representante_legal,
            'dni' => $request->dni

        ]);

        return redirect()->back()
            ->with('success','Cliente actualizado');
    }
    // ELIMINAR
    public function eliminar_cliente($id)
    {
        $cliente = ClienteModel::find($id);

        if($cliente){
            $cliente->delete();
        }

        return redirect()->back()
            ->with('success','Cliente eliminado');
    }
}