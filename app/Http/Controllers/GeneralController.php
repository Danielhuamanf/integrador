<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\LeadsModel;
class GeneralController extends Controller
{
   public function index()
    {
        return view('index');
    }
    public function guardar_lead(Request $request)
    {

        $mensaje ="Mensaje enviado";
        
        $usuario = LeadsModel::create([
            'nombre'   => $request->nombre,
            'correo'   => $request->correo,
            'telefono'   => $request->telefono,
            'estado'   => 0,
            'mensaje'   => $request->nombre
        ]);

        return redirect('/')->with('success', 'Usuario registrado correctamente');
    }
   
   
}