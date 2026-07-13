<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\EnvioDetalleModel;
use App\Models\EnvioModel;
use App\Models\ClienteModel;
use App\Models\AlmacenModel;
use App\Models\ZonasModel;
use App\Models\TipoEnvioModel;
use App\Models\DocumentosModel;
use App\Models\TrackingModel;
use App\Models\DamModel;
use App\Models\DamCostosModel;
use App\Models\PreciosModel;
use App\Models\CostoEnvioModel;
use App\Models\EstadosEnvioModel;

class VentaController extends Controller
{
  public function index()
    {

        $ventas = EnvioModel::with([
            'cliente',
            'estado_envio',
            'tipo',
        ])->get();

        $data = [
            'url' => 'ventas'
        ];

        return view(
            'admin.order_list',
            compact(
                'ventas',
                'data'
            )
        );

    }
    public function create()
    {

        $zonas = ZonasModel::all();

        $tipo_envio = TipoEnvioModel::all();

        return view(
            'ventas.create',
            compact(
                'zonas',
                'tipo_envio'
            )
        );

    }

    public function agregar_venta()
    {
        
        $almacenes = AlmacenModel::all();
        $zonas = ZonasModel::all();
        $tipo_envio = TipoEnvioModel::all();
        $data = ['url'=>'ventas'];
        return view('admin.add_venta', compact('data','almacenes','zonas','tipo_envio'));
    }
    
    public function store(Request $request)
    {

        $request->validate([

            'cliente' => 'required',

            'documento' => 'required',

            'id_zona_origen' => 'required',

            'id_zona_destino' => 'required',

            'tipo_envio' => 'required',

            'peso' => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        if($request->id_cliente == 0){

            $cliente = new ClienteModel();

            $cliente->nombre_completo =
                $request->cliente;

            $cliente->correo =
                $request->correo;

            $cliente->telefono =
                $request->telefono;

            $cliente->direccion =
                $request->direccion;

            $cliente->estado =
                'Activo';

            $cliente->tipo_persona =
                'Natural';

            $cliente->id_usuario =
                1;

            $cliente->ubigeo =
                '040101';

            $cliente->nombre_comercial =
                '';

            $cliente->representante_legal =
                '';

            if(strlen($request->documento) == 8){

                $cliente->dni =
                    $request->documento;

                $cliente->ruc =
                    '';

            }else{

                $cliente->ruc =
                    $request->documento;

                $cliente->dni =
                    0;

            }

            $cliente->save();

            $id_cliente =
                $cliente->id_cliente;

        }else{

            $id_cliente =
                $request->id_cliente;

        }

        /*
        |--------------------------------------------------------------------------
        | ENVIO
        |--------------------------------------------------------------------------
        */

        $envio = new EnvioModel();

        $envio->id_cliente =
            $id_cliente;

        $envio->id_zona_origen =
            $request->id_zona_origen;

        $envio->id_zona_destino =
            $request->id_zona_destino;

        $envio->id_almacen_origen =
            $request->id_almacen_origen;

        $envio->id_almacen_destino =
            $request->id_almacen_destino;

        $envio->peso =
            $request->peso;

        $envio->volumen =
            $request->volumen;

        $envio->descripcion =
            $request->descripcion;

        $envio->valor_declarado =
            $request->valor_declarado;

        $envio->tipo_envio =
            $request->tipo_envio;

        $envio->estado =
            1;

        $envio->fecha_envio =
            $request->fecha_envio;

        $envio->fecha_entrega =
            $request->fecha_entrega;
        $envio->alto =
            $request->alto;

        $envio->ancho =
            $request->ancho;

        $envio->largo =
            $request->largo;    
        $envio->save();

        /*
        |--------------------------------------------------------------------------
        | ENVIO DETALLE
        |--------------------------------------------------------------------------
        */

        $detalle = new EnvioDetalleModel();

        $detalle->id_envio =
            $envio->id_envio;

        $detalle->descripcion =
            $request->descripcion;

        $detalle->cantidad =
            $request->cantidad ?? 1;

        $detalle->peso_unitario =
            $request->peso;

        $detalle->valor_unitario =
            $request->valor_declarado;

        $detalle->partida_arancelaria =
            $request->partida_arancelaria;

        $detalle->save();

        /*
        |--------------------------------------------------------------------------
        | DOCUMENTOS
        |--------------------------------------------------------------------------
        */

        if($request->hasFile('voucher')){

            $ruta = $request->file('voucher')
                ->store(
                    'documentos',
                    'public'
                );

            $documento = new DocumentosModel();

            $documento->id_envio =
                $envio->id_envio;

            $documento->descripcion_doc =
                $request->descripcion;

            $documento->nombre_doc =
                'Voucher';

            $documento->url_documento =
                $ruta;

            $documento->save();

        }

        /*
        |--------------------------------------------------------------------------
        | TRACKING INICIAL
        |--------------------------------------------------------------------------
        */

        $tracking = new TrackingModel();

        $tracking->id_envio =
            $envio->id_envio;

        $tracking->id_estado =
            1;

        $tracking->comentario =
            'Envío registrado';

        $tracking->ubicacion =
            $request->id_almacen_origen;

        $tracking->fecha =
            now();

        $tracking->save();

        /*
        |--------------------------------------------------------------------------
        | REDIRECT PASO 2
        |--------------------------------------------------------------------------
        */

        return redirect()->route('ventas.costos',$envio->id_envio)
            ->with(
                'success',
                'Registro guardado correctamente'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | PASO 2 - COSTOS
    |--------------------------------------------------------------------------
    */

    public function costos($id)
{

    $envio = EnvioModel::findOrFail($id);

    $precio = PreciosModel::tarifa(
    $envio->id_zona_origen,
    $envio->id_zona_destino,
    $envio->peso,
    $envio->alto,
    $envio->ancho,
    $envio->largo,
    $envio->tipo_envio
    )->first();

        $data = [
            'url' => 'ventas'
        ];
        return view(
            'admin.add_venta2',
            compact(
                'envio',
                'precio','data'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR COSTOS
    |--------------------------------------------------------------------------
    */

    public function guardarCostos(Request $request, $id)
    {

        $envio = EnvioModel::findOrFail($id);

        $costo = new CostoEnvioModel();

        $costo->id_envio =
            $envio->id_envio;

        $costo->tipo_costo =
            $request->tipo_costo;

        $costo->descripcion =
            $request->descripcion;

        $costo->moneda =
            $request->moneda;

        $costo->monto =
            $request->monto;

        $costo->save();

        return redirect()
            ->route(
                'ventas.tracking',
                $envio->id_envio
            );

    }

    /*
    |--------------------------------------------------------------------------
    | PASO 3 - TRACKING
    |--------------------------------------------------------------------------
    */

    public function tracking($id)
    {

        $envio = EnvioModel::findOrFail($id);

        $tracking = TrackingModel::where('id_envio', $id)->first();

         $estados = EstadosEnvioModel::all();
         $data = [
            'url' => 'ventas'
        ];
        return view(
            'admin.add_venta3',
            compact(
                'envio',
                'tracking','data','estados'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR TRACKING
    |--------------------------------------------------------------------------
    */

   public function guardarTracking(Request $request, $id)
    {
        $tracking = TrackingModel::firstOrNew([
            'id_envio' => $id
        ]);

        $tracking->id_estado = $request->id_estado;
        $tracking->ubicacion = $request->ubicacion;
        $tracking->comentario = $request->comentario;
        $tracking->fecha = now();

        $tracking->save();

        return redirect()->route('ventas.dam', $id)
            ->with('success', 'Tracking actualizado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | PASO 4 - DAM
    |--------------------------------------------------------------------------
    */

    public function dam($id)
    {

        $envio = EnvioModel::findOrFail($id);
         $data = [
            'url' => 'ventas'
        ];
         $dam = DamModel::firstOrCreate(['id_envio' => $id],['estado' => 'Pendiente']);

        $costos = DamCostosModel::where('id_dam',$dam->id_dam)->get();

        return view(
            'admin.add_venta4',
            compact('envio','data','dam','costos')
        );

    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR DAM
    |--------------------------------------------------------------------------
    */

    public function guardarDam(Request $request,$id)
    {

        $dam = DamModel::where(
            'id_envio',
            $id
        )->first();

        $dam->numero_dam =
            $request->numero_dam;

        $dam->canal_control =
            $request->canal_control;

        $dam->fecha_numeracion =
            $request->fecha_numeracion;

        $dam->aduana =
            $request->aduana;

        $dam->estado =
            $request->estado;

        $dam->save();

        return redirect()->back()
            ->with(
                'success',
                'DAM actualizado'
            );

    }
    public function guardarCostoDam( Request $request, $id)
    {

        $dam = DamModel::where(
            'id_envio',
            $id
        )->first();

        $costo = new DamCostosModel();

        $costo->id_dam =
            $dam->id_dam;

        $costo->tipo_costo =
            $request->tipo_costo;

        $costo->monto =
            $request->monto;

        $costo->moneda =
            $request->moneda;

        $costo->descripcion =
            $request->descripcion;

        $costo->save();

        return redirect()->back();

    }

    /*
    |--------------------------------------------------------------------------
    | PASO 5 - CONFIRMACION
    |--------------------------------------------------------------------------
    */

   public function confirmacion($id)
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
            'url' => 'ventas'
        ];
        return view(
            'admin.add_venta5',
            compact(
                'envio',
                'costosEnvio',
                'costosDam',
                'dam','data'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | AJAX - ALMACENES POR ZONA
    |--------------------------------------------------------------------------
    */

    public function almacenesPorZona($id)
    {

        $almacenes = AlmacenModel::where(
            'id_zona',
            $id
        )->get();

        return response()->json($almacenes);

    }

    /*
    |--------------------------------------------------------------------------
    | AJAX - BUSCAR CLIENTE
    |--------------------------------------------------------------------------
    */

    public function buscarCliente(Request $request)
    {

        $buscar = $request->buscar;

        $cliente = ClienteModel::where(
                'dni',
                $buscar
            )
            ->orWhere(
                'ruc',
                $buscar
            )
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


    public function show($id)
    {

        $envio = EnvioModel::with([

            'cliente',
            'detalles',
            'tracking.estadoRelacion',
            'documentos',
            'pagos',
            'costos'

        ])->findOrFail($id);

        $totalCostos =
            $envio->costos->sum('monto');

        $totalPagado =
            $envio->pagos->sum('monto');

        $saldoPendiente =
            $totalCostos - $totalPagado;

        $data = [
            'url' => 'ventas'
        ];

        return view(
            'admin.order_detail',
            compact(
                'envio',
                'data',
                'totalCostos',
                'totalPagado',
                'saldoPendiente'
            )
        );

    }
    public function pdf($id)
    {

        $envio = EnvioModel::with([

            'cliente',
            'detalles',
            'tracking.estado',
            'documentos',
            'pagos',
            'costos'

        ])->findOrFail($id);

        $totalCostos =
            $envio->costos->sum('monto');

        $totalPagado =
            $envio->pagos->sum('monto');

        $saldoPendiente =
            $totalCostos - $totalPagado;

        $pdf = Pdf::loadView(
            'admin.envio',
            compact(
                'envio',
                'totalCostos',
                'totalPagado',
                'saldoPendiente'
            )
        );

        return $pdf->download(
            'envio_'.$envio->id_envio.'.pdf'
        );

    }
      
    // ELIMINAR
    public function destroy($id)
    {
         $envio = EnvioModel::findOrFail($id);

        $envio->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Venta eliminada'
            );
    }
}