<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EnvioModel;
use App\Models\ClienteModel;
use App\Models\DamModel;
use App\Models\DamCostosModel;
use App\Models\CostoEnvioModel;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Hash;

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
        $idUsuario = session('usuario_id');
        $cliente = ClienteModel::where('id_usuario', $idUsuario)->first();
        $idCliente = $cliente['id_cliente'];
         $ordenes = EnvioModel::with([

            'tracking.estado',
            'zonaOrigen',
            'zonaDestino',
            'costos'

        ])
        ->where('id_cliente', $idCliente)
        ->orderBy('id_envio', 'desc')
        ->paginate(10);

        
         $data = ['url'=>'envios'];
        // print_r($idCliente);
        return view('cliente.envios_cliente', compact('ordenes','data'));
    }
    public function configuracion(){
        $idUsuario = session('usuario_id');
        $usuario = UsuarioModel::where('id_usuario', $idUsuario)->first();
        $cliente = ClienteModel::where('id_usuario', $idUsuario)->first();
         $data = ['url'=>'configuracion'];
        // print_r($idCliente);
        return view('cliente.configuracion_cliente', compact('cliente','usuario','data'));
    }
    public function updateConfiguracion(Request $request)
    {

       
        $idUsuario = session('usuario_id');

        $usuario = UsuarioModel::where(
            'id_usuario',
            $idUsuario
        )->first();

       

        $cliente = ClienteModel::where(
            'id_usuario',
            $idUsuario
        )->first();

    
        $request->validate([

            'telefono' => 'required',

            'direccion' => 'required',

            'correo' => 'required|email',

            'password_actual' => 'nullable',

            'password_nuevo' =>
                'nullable|min:8|same:password_confirmacion'

        ]);

       

        if($request->password_actual){

            if(
                !Hash::check(
                    $request->password_actual,
                    $usuario->password
                )
            ){

                return back()->with(
                    'error',
                    'La contraseña actual es incorrecta'
                );

            }

            $usuario->password = Hash::make(
                $request->password_nuevo
            );

        }

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR USUARIO
        |--------------------------------------------------------------------------
        */

        $usuario->correo =
            $request->correo;

        $usuario->save();

        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CLIENTE
        |--------------------------------------------------------------------------
        */

        if($cliente){

            $cliente->telefono =
                $request->telefono;

            $cliente->direccion =
                $request->direccion;

            $cliente->correo =
                $request->correo;

            $cliente->save();

        }

        return back()->with(
            'success',
            'Configuración actualizada correctamente'
        );

    }
    public function detalle_orden($id)
    {
        $envio = EnvioModel::with([
            'cliente',
            'detalle',
            'tracking.estado',
            'dam',
            'documentos'
        ])->findOrFail($id);

        $costosEnvio = CostoEnvioModel::where(
            'id_envio',
            $id
        )->get();

        $dam = DamModel::where(
            'id_envio',
            $id
        )->first();

        $costosDam = [];

        if($dam){

            $costosDam = DamCostosModel::where(
                'id_dam',
                $dam->id_dam
            )->get();

        }
        $data = [
            'url' => 'envios'
        ];
        return view(
            'cliente..detalle_orden',
            compact(
                'envio',
                'costosEnvio',
                'costosDam',
                'dam','data'
            )
        );
       
    }
    //admin
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