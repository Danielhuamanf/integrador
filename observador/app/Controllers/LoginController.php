<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function validar()
    {
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        $usuarioModel = new UsuarioModel();

        $usuario = $usuarioModel
                    ->where('correo',$correo)
                    ->first();
                    
        if(!$usuario)
        {
            return redirect()->back()->with('error','Usuario no existe');
        }
        
        if(!password_verify($password,$usuario['password']))
        {
            return redirect()->back()->with('error','Contraseña incorrecta');
        }

        session()->set([
            'id_usuario'=>$usuario['id_usuario'],
            'nombre'=>$usuario['nombre'],
            'rol'=>$usuario['rol']
        ]);
        if($usuario['rol'] == 'superadmin'){
             return redirect()->to('/admin'); 
        }
        else{
           return redirect()->to('/repositorio'); 
        }

        
    }

    public function logout()
    {

        session()->destroy();

        return redirect()->to('/login');
    }
    public function logout_usuario()
    {
        $idUsuario=session()->get('id_usuario');

        $bloqueadoModel=new \App\Models\ArchivoBloqueadoModel();

        $bloqueadoModel
            ->where('id_usuario',$idUsuario)
            ->set([
                'activo'=>0
            ])
            ->update();

        session()->destroy();

        return redirect()->to('/login');
    }
}