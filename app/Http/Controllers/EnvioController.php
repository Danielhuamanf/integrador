<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\EnvioModel;
class EnvioController extends Controller
{
   public function index()
    {
        
    }
     public function detalle($id)
    {
            $data = ['url' => 'documentos'];
        $envio = EnvioModel::with([
            'cliente',
            'detalles',
            'tracking',
            'documentos',
            'pagos',
            'costos',
            'dam'
        ])->findOrFail($id);

        $totalCostos = $envio->costos->sum('monto');
        $totalPagado = $envio->pagos->sum('monto');
        $saldoPendiente = $totalCostos - $totalPagado;

        return view('admin.order_detail', compact(
            'envio',
            'totalCostos',
            'totalPagado',
            'saldoPendiente','data'
        ));
    }
   
}