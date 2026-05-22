<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\EnvioModel;
use App\Models\AlmacenModel;
use App\Models\ZonasModel;
class AlmacenController extends Controller
{
    public function index()
    {
         $almacenes = AlmacenModel::with('zona')->get();

        $zonas = ZonasModel::all();

        $data = [
            'url' => 'almacen'
        ];

        
        return view('admin.almacenes', compact('almacenes','zonas','data'));
    }

    public function store(Request $request)
    {
        AlmacenModel::create($request->all());

        return redirect()->back()->with('success', 'Almacén registrado');
    }

    public function update(Request $request, $id)
    {
        $almacen = AlmacenModel::findOrFail($id);

        $almacen->update($request->all());

        return redirect()->back()->with('success', 'Almacén actualizado');
    }
    public function destroy($id)
    {
        AlmacenModel::destroy($id);

        return redirect()->back()->with('success', 'Almacén eliminado');
    }

   public function productos($id)
    {

        $almacen = AlmacenModel::findOrFail($id);

        $productos = EnvioModel::where(function($query) use ($id){

            $query->where(function($q) use ($id){

                $q->where('estado', 'pendiente')
                  ->where('id_almacen_origen', $id);

            })

            ->orWhere(function($q) use ($id){

                $q->where('estado', 'en almacen')
                  ->where('id_almacen_destino', $id);

            });

        })->get();
         $data = ['url'=>'almacen'];
        return view('admin.almacenes_productos',compact('almacen', 'productos','data') );

    }
    public function porZona($id)
    {
        $almacenes = AlmacenModel::where('id_zona', $id)
                        ->where('estado', 1)
                        ->get();

        return response()->json($almacenes);    
    }
}