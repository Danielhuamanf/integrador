<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\EnvioModel;
class VentaController extends Controller
{
   public function index()
    {
        
        $ventas = EnvioModel::all();
        return view('admin.order_list', compact('ventas'));
    }

    // FORM CREAR
    public function create()
    {
       
    }

    // GUARDAR
    public function store(Request $request)
    {
       
    }

    // ELIMINAR
    public function destroy($id)
    {
        
    }
}