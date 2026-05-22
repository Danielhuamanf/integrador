<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\ZonasModel;
class ZonaController extends Controller
{
    public function index()
    {
        $zonas = ZonasModel::orderBy('id_zona', 'desc')->get();
        $data = ['url' => 'zonas'];

        return view('admin.zona_list', compact('zonas', 'data'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre_zona' => 'required|max:255',
            'descripcion' => 'nullable|max:255',
            'direccion'   => 'nullable|max:255',
        ]);

        ZonasModel::create([
            'nombre_zona' => $request->nombre_zona,
            'descripcion' => $request->descripcion,
            'direccion'   => $request->direccion,
        ]);

        return redirect()
            ->route('zonas.index')
            ->with('success', 'Zona registrada correctamente');
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_zona' => 'required|max:255',
            'descripcion' => 'nullable|max:255',
            'direccion'   => 'nullable|max:255',
        ]);

        $zona = ZonasModel::find($id);

        if (!$zona) {
            return redirect()
                ->route('zonas.index')
                ->with('error', 'Zona no encontrada');
        }

        $zona->update([
            'nombre_zona' => $request->nombre_zona,
            'descripcion' => $request->descripcion,
            'direccion'   => $request->direccion,
        ]);

        return redirect()
            ->route('zonas.index')
            ->with('success', 'Zona actualizada correctamente');
    }

    // ELIMINAR
    
}