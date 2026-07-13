<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Models\MensajesModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /* =========================
       VISTA ADMIN
    ========================= */
    public function index()
    {
        return view('admin.chat');
    }
    public function vistaAdmin()
    {
        // seguridad básica: admin o agente
        if (!in_array(session('usuario_rol'), [1, 2])) {
            return redirect('/login');
        }
        $data = [
            'url' => 'Chat'
        ];
        return view('admin.chat',compact('data'));
    }
    public function vistaCliente()
    {
        // si es admin no entra aquí
        if (session('usuario_rol') == 1) {
            return redirect('/home_admin');
        }
         $data = [
            'url' => 'Chat'
        ];
        return view('cliente.chat_cliente',compact('data'));
    }
    /* =========================
       MENSAJES ENTRE 2 USUARIOS
    ========================= */
    public function mensajes($id)
    {
        $yo = session('usuario_id');

        // marcar como leído
        MensajesModel::where('id_emisor', $id)
            ->where('id_receptor', $yo)
            ->where('estado', 0)
            ->update(['estado' => 1]);

        // traer conversación
        return MensajesModel::where(function ($q) use ($yo, $id) {
                $q->where('id_emisor', $yo)
                  ->where('id_receptor', $id);
            })
            ->orWhere(function ($q) use ($yo, $id) {
                $q->where('id_emisor', $id)
                  ->where('id_receptor', $yo);
            })
            ->orderBy('id_mensaje', 'asc')
            ->get();
    }

    /* =========================
       ENVIAR MENSAJE
    ========================= */
    public function contienePalabrasObscenas($texto)
    {
        $palabrasProhibidas = [
            'mierda',
            'puta',
            'puto',
            'carajo',
            'coño',
            'pendejo',
            'idiota'
        ];

        $texto = mb_strtolower($texto);

        foreach ($palabrasProhibidas as $palabra) {
            if (strpos($texto, $palabra) !== false) {
                return true;
            }
        }

        return false;
    }
    public function enviar(Request $request)
    {
        $palabra = $request->mensaje;
        if ($this->contienePalabrasObscenas($palabra)) {
            $palabra ="palabra obscena";
        }
        MensajesModel::create([
            'id_emisor' => session('usuario_id'),
            'id_receptor' => $request->id_receptor,
            'mensaje' => $palabra,
            'estado' => 0
        ]);

        return response()->json(['ok' => true]);
    }

    /* =========================
       CONVERSACIONES (ADMIN)
       SOLO USUARIOS CON MENSAJES
    ========================= */
    public function conversaciones()
    {
        $yo = session('usuario_id');

        $mensajes = MensajesModel::where('id_emisor', $yo)
            ->orWhere('id_receptor', $yo)
            ->orderBy('id_mensaje', 'desc')
            ->get();

        $chats = [];

        foreach ($mensajes as $m) {

            $otro = ($m->id_emisor == $yo)
                ? $m->id_receptor
                : $m->id_emisor;

            // evitar duplicados
            if (isset($chats[$otro])) continue;

            $usuario = UsuarioModel::find($otro);

            if (!$usuario) continue;

            $noLeidos = MensajesModel::where('id_emisor', $otro)
                ->where('id_receptor', $yo)
                ->where('estado', 0)
                ->count();

            $chats[$otro] = [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->username,
                'no_leidos' => $noLeidos
            ];
        }

        return response()->json(array_values($chats));
    }
}