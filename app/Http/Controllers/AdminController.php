<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\UsuarioModel;
use App\Models\leadsModel;
class AdminController extends Controller
{
   public function home()
    {
        $variable = [];
        return view('admin.dashboard', compact('variable'));
    }
    public function ver_leads()
    {
        $usuarios = LeadsModel::all();
        return view('admin.leads', compact('usuarios'));
    }
    // FORM CREAR
    public function create()
    {
        return view('usuarios.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        Usuario::create([
            'username' => $request->username,
            'password' => $request->password,
            'saldo' => $request->saldo
        ]);

        return redirect()->route('usuarios.index');
    }

    // ELIMINAR
    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();
        return redirect()->route('usuarios.index');
    }
}