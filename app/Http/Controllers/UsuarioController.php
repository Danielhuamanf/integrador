<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //roles
    //1 == administrador
    //2 == agentes 
    //3 == usuarios
    // =========================
    // LISTAR USUARIOS
    // =========================
    public function index()
    {
        return response()->json(Usuario::all());
    }

    // =========================
    // FORM LOGIN
    // =========================
    public function login()
    {

        return view('login');
    }
    public function register()
    {
        return view('register');
    }

    // =========================
    // VER USUARIO
    // =========================
    public function show($id)
    {
        $usuario = UsuarioModel::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }
    public function ver_usuarios()
    {

        $usuarios = UsuarioModel::all();
        return view('admin.usuarios', compact('usuarios'));  
    }

    // =========================
    // REGISTRAR USUARIO
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'username'   => 'required|string|max:100',
            'correo'   => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6',
            
        ]);

        $usuario = UsuarioModel::create([
            'username'   => $request->username,
            'correo'   => $request->correo,
            'password' => Hash::make($request->password),
            'rol'      => 3
        ]);

        return redirect('/login')->with('success', 'Usuario registrado correctamente');
    }

    // =========================
    // ACTUALIZAR USUARIO
    // =========================
    public function update(Request $request, $id)
    {
        $usuario = UsuarioModel::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->update($request->only([
            'nombre',
            'correo',
            'rol',
            'estado'
        ]));

        return response()->json($usuario);
    }

    // =========================
    // DESACTIVAR USUARIO
    // =========================
    public function destroy($id)
    {
        $usuario = UsuarioModel::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->estado = 'inactivo';
        $usuario->save();

        return response()->json(['message' => 'Usuario desactivado']);
    }

    // =========================
    // LOGIN MANUAL (SIN AUTH)
    // =========================
    public function loginpost(Request $request)
    {
        $request->validate([
            'correo'   => 'required',
            'password' => 'required'
        ]);

        $usuario = UsuarioModel::where('correo', $request->correo)->first();

        if (!$usuario) {
            return back()->withErrors([
                'correo' => 'Usuario no encontrado'
            ]);
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors([
                'correo' => 'Contraseña incorrecta'
            ]);
        }

        // Guardar sesión manual
        session([
            'usuario_id'     => $usuario->id_usuario,
            'usuario_rol'    => $usuario->rol,
            'usuario_username' => $usuario->username
        ]);

        return $usuario->rol === 1
            ? redirect('/home_admin')
            : redirect('/home_cliente');
    }

    // =========================
    // LOGOUT SIN AUTH
    // =========================
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}