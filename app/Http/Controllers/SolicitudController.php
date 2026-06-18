<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudModel;
use App\Models\UsuarioModel;
use App\Models\CambioPasswordModel;
use App\Models\EnvioModel;
use App\Models\ClienteModel;
use App\Mail\SolicitudAprobadaMail;
use App\Mail\SolicitudDesaprobadaMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class SolicitudController extends Controller
{

    public function index()
    {
        $solicitudes= SolicitudModel::all();
        $passwords = CambioPasswordModel::orderBy('id','desc')->get();
        return view(
            'solicitudes.index',
            compact('solicitudes','passwords')
        );
    }

    public function create()
    {
        return view(
            'solicitudes.create'
        );
    }

    public function store(Request $request)
    {

        SolicitudModel::create([

        'id_cliente'=>$request->id_cliente,

        'id_envio'=>$request->id_envio,

        'tipo'=>$request->tipo,

        'motivo'=>$request->motivo,

        'estado'=>'PENDIENTE'

        ]);

        return redirect(
        '/solicitudes'
        );

    }
    public function index_cliente()
    {
        $usuario=session('usuario_id');
        $cliente = ClienteModel::where(
            'id_usuario',
            $usuario
        )->first();

        $solicitudes=SolicitudModel::where('id_cliente', $cliente->id_cliente)->latest()->get();
        
         $data = [
            'url' => 'solicitud'
        ];
        return view(
        'cliente.solicitud_lista',
        compact('solicitudes','data')
        );
    }

    public function create_cliente()
    {
         $usuario=session('usuario_id');
         $cliente = ClienteModel::where('id_usuario',$usuario)->first();
         $data = [
            'url' => 'solicitud'
        ];
        $envios=EnvioModel::where('id_cliente',$cliente->id_cliente)->get();
     
        return view('cliente.solicitud_create',compact('envios','data'));
    }
    public function post_procesar_solicitud_cliente(Request $request)
    {

        $request->validate([
            'id_envio' => 'required',
            'tipo' => 'required'
        ]);

        $usuario = session('usuario_id');

        $cliente = ClienteModel::where(
            'id_usuario',
            $usuario
        )->first();

        if(!$cliente)
        {
            return back()->with(
                'error',
                'Cliente no encontrado'
            );
        }

        SolicitudModel::create([

            'id_cliente' => $cliente->id_cliente,

            'id_envio' => $request->id_envio,

            'tipo' => $request->tipo,

            'motivo' => $request->motivo,

            'estado' => 'pendiente',

            'respuesta' => null,

            'aprobado_por' => null,

            'fecha_aprobacion' => null,

            'fecha_cierre' => null,

            // TRACKING
            'numero_tracking' => $request->numero_tracking,
            'descripcion_tracking' => $request->descripcion_tracking,

            // ESTADO ENVIO
            'descripcion_estado_envio' => $request->descripcion_estado_envio,

            // DAM
            'numero_dam' => $request->numero_dam,
            'anio_dam' => $request->anio_dam,
            'descripcion_dam' => $request->descripcion_dam,

            // DOCUMENTOS
            'tipo_documento' => $request->tipo_documento,
            'descripcion_documento' => $request->descripcion_documento

        ]);

        return redirect()
            ->route('solicitudes')
            ->with(
                'success',
                'Solicitud registrada correctamente'
            );
    }
    public function indexOperador()
    {
        $data = [
            'url' => 'solicitudes'
        ];
        $solicitudes=SolicitudModel::with( ['cliente', 'envio' ])->latest()->get();
         $passwords = CambioPasswordModel::with('usuario')
        ->orderBy('id_solicitud_cambio_password','desc')
        ->get();
        return view('admin.solicitudes', compact('solicitudes','data','passwords')  );

    }


    public function procesar(Request $request)
    {

        $s=Solicitud::findOrFail($request->id_solicitud);

        if($request->accion =='aprobar'){

        $s->estado='APROBADO';

        $s->fecha_aprobacion=
        now();

        }

        if(
        $request->accion
        ==
        'rechazar'
        ){

        $s->estado='RECHAZADO';

        }

        if(
        $request->accion
        ==
        'atender'
        ){

        $s->estado='CERRADO';

        $s->fecha_cierre=
        now();

        }

        $s->respuesta=
        $request->respuesta;

        $s->save();

        return back();

    }
    public function ver($id)
    {
        $solicitud = SolicitudModel::with([
            'cliente',
            'envio'
        ])->findOrFail($id);
        $data = [
            'url' => 'solicitudes'
        ];
        return view(
            'admin.ver_solicitud',
            compact('solicitud','data')
        );
    }
    public function estado($id)
    {
        $solicitud = SolicitudModel::with([
            'cliente',
            'envio'
        ])->findOrFail($id);
        $data = [
            'url' => 'solicitudes'
        ];
        return view(
            'admin.estado_solicitud',
            compact('solicitud','data')
        );
    }
    public function actualizarEstado(Request $request)
    {
        $request->validate([
            'id_solicitud' => 'required',
            'estado' => 'required'
        ]);

        $solicitud = SolicitudModel::findOrFail(
            $request->id_solicitud
        );

        $solicitud->estado = $request->estado;

        if($request->estado == 'APROBADO'){
            $solicitud->fecha_aprobacion = now();
        }

        if($request->estado == 'CERRADO'){
            $solicitud->fecha_cierre = now();
        }

        $solicitud->save();

        return redirect()
            ->route('solicitudes.operador')
            ->with(
                'success',
                'Estado actualizado correctamente'
            );
    }
    public function actualizarEstadoAjax(Request $request)
    {
        $solicitud = SolicitudModel::findOrFail(
            $request->id_solicitud
        );

        $solicitud->estado = $request->estado;
        $solicitud->respuesta = $request->respuesta;

        if($request->estado=='APROBADO'){
            $solicitud->fecha_aprobacion = now();
        }

        if($request->estado=='CERRADO'){
            $solicitud->fecha_cierre = now();
        }

        $solicitud->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado'
        ]);
    }
    public function recuperar_password(){
         return view('olvide' );
    }
     public function solicitar_cambio_password(Request $request)
    {

        $request->validate([
            'correo' => 'required|email',
            'password_nueva' => 'required|min:6',
            'password_confirmacion' => 'required|same:password_nueva'
        ]); 

        $usuario = UsuarioModel::where(
            'correo',
            $request->correo
        )->first();

        if(!$usuario)
        {
            return back()
            ->with('error','El correo no existe');
        }

        CambioPasswordModel::create([
            'id_usuario' => $usuario->id_usuario,
            'password' => Hash::make($request->password_nueva),
            'estado' => 'Pendiente'
        ]);

        return back()
        ->with('success',
        'Solicitud enviada correctamente, su cambio sera atendido a la brevedad');
    }

    public function index_admin_password()
    {
        $solicitudes = CambioPasswordModel::with('usuario')
        ->orderBy('id_solicitud_cambio_password','desc')
        ->get();

        return view(
            'admin.cambio_password',
            compact('solicitudes')
        );
    }

    public function aprobar($id)
    {
        $solicitud = CambioPasswordModel::findOrFail($id);

        $usuario = UsuarioModel::findOrFail(
            $solicitud->id_usuario
        );

        $usuario->password = $solicitud->password;

        $usuario->save();

        $solicitud->estado = 'Aprobado';

        $solicitud->save();

        // ENVIAR CORREO
        Mail::to($usuario->correo)
        ->send(new SolicitudAprobadaMail($usuario));

        return back()
        ->with('success',
        'Contraseña actualizada');
    }

    public function rechazar($id)
    {
        $solicitud = CambioPasswordModel::findOrFail($id);
         $usuario = UsuarioModel::findOrFail(
            $solicitud->id_usuario
        );
        $solicitud->estado = 'Rechazado';

        $solicitud->save();
         // ENVIAR CORREO
        Mail::to($usuario->correo)
        ->send(new SolicitudDesaprobadaMail($usuario));
        return back()
        ->with('success',
        'Solicitud rechazada');
    }

}