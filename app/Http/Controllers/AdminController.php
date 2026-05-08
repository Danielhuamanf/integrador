<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\UsuarioModel;
class AdminController extends Controller
{
   public function home()
    {
        $reportes = '';
        return view('admin.dashboard', compact('reportes'));
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