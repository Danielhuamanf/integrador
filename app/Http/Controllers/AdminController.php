<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\UsuarioModel;
use App\Models\leadsModel;
class AdminController extends Controller
{
    public function home()
    {
        $data = ['url'=>'home','variable'=>[]];
        return view('admin.home', compact('data'));
    }
    public function dashboard()
    {
        $data = ['url'=>'dashboard','variable'=>[]];
        return view('admin.dashboard', compact('data'));
    }
    public function ver_leads()
    {
        $data = ['url'=>'leads'];
        $usuarios = LeadsModel::all();
        return view('admin.leads', compact('usuarios','data'));
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
      public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}