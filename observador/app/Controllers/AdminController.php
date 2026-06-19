<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\AuditoriaArchivoModel;
use App\Models\BackupModel;

class AdminController extends BaseController
{
    protected $usuarioModel;
    protected $auditoriaModel;
    protected $backupModel;

    private $rutaProyecto = 'C:/xampp/htdocs/integrador';
    private $rutaBackups = 'C:/backups';

    public function __construct()
    {
        if (!session()->has('id_usuario')) {
            header('Location: '.base_url('login'));
            exit;
        }

        if (session()->get('rol') != 'superadmin') {
            exit('Acceso denegado');
        }

        $this->usuarioModel = new UsuarioModel();
        $this->auditoriaModel = new AuditoriaArchivoModel();
        $this->backupModel = new BackupModel();
    }

    public function index()
    {
        $usuarios = $this->usuarioModel
            ->orderBy('nombre')
            ->findAll();

        $auditoria = $this->auditoriaModel
            ->select('auditoria_archivos.*, usuarios.nombre')
            ->join('usuarios','usuarios.id_usuario=auditoria_archivos.id_usuario')
            ->orderBy('fecha','DESC')
            ->limit(100)
            ->find();

        $backups = $this->backupModel
            ->orderBy('fecha','DESC')
            ->findAll();

        return view('admin',[
            'usuarios'=>$usuarios,
            'auditoria'=>$auditoria,
            'backups'=>$backups
        ]);
    }

    public function guardarUsuario()
    {
        $this->usuarioModel->insert([
            'nombre'=>$this->request->getPost('nombre'),
            'correo'=>$this->request->getPost('correo'),
            'password'=>password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'rol'=>$this->request->getPost('rol')
        ]);

        return redirect()->back();
    }

    public function crearBackup()
    {
        $nombre = 'backup_'.date('Ymd_His');

        $destino = $this->rutaBackups.'/'.$nombre;

        $this->copiarDirectorio(
            $this->rutaProyecto,
            $destino
        );

        $this->backupModel->insert([
            'nombre'=>$nombre,
            'ruta'=>$destino,
            'fecha'=>date('Y-m-d H:i:s'),
            'id_usuario'=>session()->get('id_usuario')
        ]);

        return redirect()->back();
    }

    public function restaurarBackup($id)
    {
        $backup = $this->backupModel->find($id);

        if(!$backup)
        {
            return redirect()->back();
        }

        $this->copiarDirectorio(
            $backup['ruta'],
            $this->rutaProyecto
        );

        return redirect()->back();
    }

    private function copiarDirectorio($origen, $destino)
    {
        if (!is_dir($destino))
        {
            mkdir($destino,0777,true);
        }

        $archivos = scandir($origen);

        foreach($archivos as $archivo)
        {
            if($archivo=="." || $archivo=="..")
            {
                continue;
            }

            $rutaOrigen = $origen.'/'.$archivo;
            $rutaDestino = $destino.'/'.$archivo;

            if(is_dir($rutaOrigen))
            {
                $this->copiarDirectorio(
                    $rutaOrigen,
                    $rutaDestino
                );
            }
            else
            {
                copy(
                    $rutaOrigen,
                    $rutaDestino
                );
            }
        }
    }
}