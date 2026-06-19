<?php

namespace App\Controllers;
use App\Models\ArchivoBloqueadoModel;
use App\Models\VersionArchivoModel;
use App\Models\AuditoriaArchivoModel;

class RepositorioController extends BaseController
{
    private $rutaProyecto = 'C:/xampp/htdocs/integrador';
    private $bloqueadoModel;
    private $versionModel;
    private $auditoriaModel;

    public function __construct()
    {
        if(!session()->has('id_usuario'))
        {
            header("Location: ".base_url('/login'));
            exit;
        }
        $this->bloqueadoModel = new ArchivoBloqueadoModel();
        $this->versionModel = new VersionArchivoModel();
        $this->auditoriaModel = new AuditoriaArchivoModel();
    }
    public function index()
    {
        $ruta = $this->request->getGet('ruta');

        if(!$ruta){
            $ruta = $this->rutaProyecto;
        }

        $archivos = $this->listarArchivos($ruta);

       $contenido = '';

        $archivoSeleccionado = $this->request->getGet('archivo');

        $soloLectura = false;
        $mensajeBloqueo = '';

        if($archivoSeleccionado && file_exists($archivoSeleccionado))
        {
            $contenido = file_get_contents($archivoSeleccionado);

            $idUsuario = session()->get('id_usuario');

            /*
            Liberar todos los archivos que tenga abiertos
            el usuario actual
            */
            $this->bloqueadoModel
                ->where('id_usuario',$idUsuario)
                ->set([
                    'activo'=>0
                ])
                ->update();
            $bloqueo = $this->bloqueadoModel
                ->where('archivo',$archivoSeleccionado)
                ->where('activo',1)
                ->first();

           if($bloqueo)
            {
                if($bloqueo['id_usuario'] != $idUsuario)
                {
                    $soloLectura=true;
                    $mensajeBloqueo='Este archivo está siendo editado por otro usuario';
                }
            }
            else
            {
                $this->bloqueadoModel->insert([
                    'archivo'=>$archivoSeleccionado,
                    'id_usuario'=>$idUsuario,
                    'fecha_inicio'=>date('Y-m-d H:i:s'),
                    'activo'=>1
                ]);
            }
        }

        return view('index',[
            'soloLectura'=>$soloLectura,
            'mensajeBloqueo'=>$mensajeBloqueo,
            'arbol'=>$this->obtenerArbol($this->rutaProyecto),
            'archivos'=>$archivos,
            'rutaActual'=>$ruta,
            'archivoSeleccionado'=>$archivoSeleccionado,
            'contenido'=>$contenido
        ]);
    }
   private function obtenerArbol($ruta)
{
    $ignorar = [
        '.',
        '..',
        'vendor',
        'node_modules',
        '.git',
        'storage',
        'bootstrap',
        'public/build'
    ];

    $items=[];

    foreach(scandir($ruta) as $item)
    {
        if(in_array($item,$ignorar))
            continue;

        $rutaCompleta=$ruta.DIRECTORY_SEPARATOR.$item;

        if(is_dir($rutaCompleta))
        {
            $items[]=[
                'tipo'=>'carpeta',
                'nombre'=>$item,
                'ruta'=>$rutaCompleta,
                'hijos'=>$this->obtenerArbol($rutaCompleta)
            ];
        }
        else
        {
            $items[]=[
                'tipo'=>'archivo',
                'nombre'=>$item,
                'ruta'=>$rutaCompleta
            ];
        }
    }

    return $items;
}
    private function listarArchivos($ruta)
    {
        $resultado = [];

        $items = scandir($ruta);

        foreach ($items as $item) {

            if ($item == '.' || $item == '..') {
                continue;
            }

            $rutaCompleta = $ruta . DIRECTORY_SEPARATOR . $item;

            if (is_dir($rutaCompleta)) {

                $resultado[] = [
                    'nombre' => $item,
                    'tipo' => 'carpeta',
                    'ruta' => $rutaCompleta
                ];

            } else {

                $resultado[] = [
                    'nombre' => $item,
                    'tipo' => 'archivo',
                    'ruta' => $rutaCompleta
                ];
            }
        }

        return $resultado;
    }

    public function editar()
    {
        $ruta = $this->request->getGet('ruta');

        if (!file_exists($ruta)) {
            return "Archivo no encontrado";
        }

        $contenido = file_get_contents($ruta);

        return view('editar', [
            'ruta' => $ruta,
            'contenido' => $contenido
        ]);
    }

   public function guardar()
    {
        $ruta = $this->request->getPost('ruta');
        $contenidoNuevo = $this->request->getPost('contenido');

        if(!file_exists($ruta))
        {
            return redirect()->back();
        }

        $contenidoAnterior = file_get_contents($ruta);

        $idUsuario = session()->get('id_usuario');

        //Guardar versión anterior
        $this->versionModel->insert([
            'archivo'=>$ruta,
            'contenido'=>$contenidoAnterior,
            'id_usuario'=>$idUsuario,
            'comentario'=>'Guardado automático',
            'fecha'=>date('Y-m-d H:i:s')
        ]);

        //Guardar archivo
        file_put_contents($ruta,$contenidoNuevo);

        //Auditoría
        $this->auditoriaModel->insert([
            'id_usuario'=>$idUsuario,
            'archivo'=>$ruta,
            'accion'=>'editar',
            'fecha'=>date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }
    public function liberar()
    {
        $archivo = $this->request->getPost('archivo');

        $this->bloqueadoModel
            ->where('archivo',$archivo)
            ->set(['activo'=>0])
            ->update();

        return $this->response->setJSON([
            'ok'=>true
        ]);
    }
}