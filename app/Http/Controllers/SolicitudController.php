<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudModel;

use App\Models\EnvioModel;
class SolicitudController extends Controller
{

    public function index()
    {
        $solicitudes=
        SolicitudModel::all();

        return view(
            'solicitudes.index',
            compact('solicitudes')
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
        $cliente=session('id_usuario');

        $solicitudes=
        SolicitudModel::where('id_cliente', $cliente)
        ->latest()
        ->get();
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
         $cliente=session('id_usuario');
         $data = [
            'url' => 'solicitud'
        ];
        $envios=
        EnvioModel::where(
        'id_cliente',
        $cliente
        )->get();

        return view(
        'cliente.solicitud_create',
        compact('envios','data')
        );
    }

    public function indexOperador()
    {

        $solicitudes=
        Solicitud::with( ['cliente', 'envio' ])
        ->latest()
        ->get();

        return view('admin.solicitudes', compact('solicitudes' )  );

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

}