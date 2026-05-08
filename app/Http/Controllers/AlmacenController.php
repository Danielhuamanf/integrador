<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Usuario;
class Controller2 extends Controller
{
   public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
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