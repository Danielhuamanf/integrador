<?php

namespace App\Http\Controllers;

use App\Mail\IncidenciaRespuestaMail;
use App\Models\IncidenciaComentarioModel;
use App\Models\IncidenciaModel;
use App\Models\UsuarioModel;
use App\Services\IncidenciaCorreoImporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IncidenciaController extends Controller
{
    private array $estados = [
        'pendiente' => 'Pendiente',
        'clasificacion' => 'Clasificacion',
        'asignado' => 'Asignado',
        'en_diagnostico' => 'En diagnostico',
        'en_resolucion' => 'En resolucion',
        'validacion' => 'Validacion',
        'cerrado' => 'Cerrado',
    ];

    private array $prioridades = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
        'critica' => 'Critica',
    ];

    private array $niveles = [
        'bajo' => 'Bajo',
        'medio' => 'Medio',
        'alto' => 'Alto',
        'critico' => 'Critico',
    ];

    private array $modulos = [
        'envios' => 'Envios',
        'documentos' => 'Documentos',
        'almacen' => 'Almacen',
        'facturacion' => 'Facturacion',
        'usuarios' => 'Usuarios',
        'sistema' => 'Sistema',
        'otro' => 'Otro',
    ];

    private array $categorias = [
        'soporte' => 'Soporte tecnico',
        'sistema' => 'Error del sistema',
        'envio' => 'Problema de envio',
        'facturacion' => 'Facturacion',
        'consulta' => 'Consulta',
        'otro' => 'Otro',
    ];

    public function index(Request $request)
    {
        $data = ['url' => 'incidencias'];

        $query = IncidenciaModel::with(['creador', 'asignado']);

        if ($buscar = trim((string) $request->get('buscar'))) {
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'like', "%$buscar%")
                    ->orWhere('titulo', 'like', "%$buscar%")
                    ->orWhere('descripcion', 'like', "%$buscar%")
                    ->orWhere('remitente', 'like', "%$buscar%")
                    ->orWhere('correo_remitente', 'like', "%$buscar%");
            });
        }

        foreach (['estado', 'prioridad', 'modulo_afectado', 'id_usuario_asignado'] as $campo) {
            if ($valor = $request->get($campo)) {
                $query->where($campo, $valor);
            }
        }

        $incidencias = $query->orderBy('id_incidencia', 'desc')->paginate(20);
        $usuarios = $this->usuariosResponsables();

        return view('admin.incidencias.index', $this->catalogos() + compact('incidencias', 'usuarios', 'data'));
    }

    public function create()
    {
        $data = ['url' => 'incidencias'];
        $usuarios = $this->usuariosResponsables();

        return view('admin.incidencias.create', $this->catalogos() + compact('data', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:200',
            'descripcion' => 'nullable',
            'remitente' => 'nullable|max:150',
            'correo_remitente' => 'nullable|email|max:150',
            'modulo_afectado' => 'nullable|max:100',
            'categoria' => 'nullable|max:100',
            'impacto' => 'required|in:bajo,medio,alto,critico',
            'urgencia' => 'required|in:bajo,medio,alto,critico',
            'prioridad' => 'nullable|in:baja,media,alta,critica',
            'id_usuario_asignado' => 'nullable|exists:usuarios,id_usuario',
        ]);

        $usuario = $request->correo_remitente
            ? UsuarioModel::where('correo', $request->correo_remitente)->first()
            : null;

        IncidenciaModel::crearConCodigo([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad ?: IncidenciaModel::calcularPrioridad($request->impacto, $request->urgencia),
            'estado' => $request->id_usuario_asignado ? 'asignado' : 'pendiente',
            'modulo_afectado' => $request->modulo_afectado,
            'categoria' => $request->categoria,
            'impacto' => $request->impacto,
            'urgencia' => $request->urgencia,
            'remitente' => $request->remitente,
            'correo_remitente' => $request->correo_remitente,
            'asunto_correo' => $request->titulo,
            'fecha_recepcion' => now(),
            'origen' => 'manual',
            'id_usuario_creador' => $usuario?->id_usuario ?? session('id_usuario') ?? 1,
            'id_usuario_asignado' => $request->id_usuario_asignado,
        ]);

        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada correctamente');
    }

    public function show($id)
    {
        $data = ['url' => 'incidencias'];
        $incidencia = IncidenciaModel::with(['creador', 'asignado', 'cerradoPor', 'comentarios.usuario'])->findOrFail($id);
        $usuarios = $this->usuariosResponsables();

        return view('admin.incidencias.show', $this->catalogos() + compact('incidencia', 'usuarios', 'data'));
    }

    public function edit($id)
    {
        $data = ['url' => 'incidencias'];
        $incidencia = IncidenciaModel::findOrFail($id);
        $usuarios = $this->usuariosResponsables();

        return view('admin.incidencias.edit', $this->catalogos() + compact('incidencia', 'usuarios', 'data'));
    }

    public function update(Request $request, $id)
    {
        $incidencia = IncidenciaModel::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:200',
            'descripcion' => 'nullable',
            'estado' => 'required|in:' . implode(',', array_keys($this->estados)),
            'modulo_afectado' => 'nullable|max:100',
            'categoria' => 'nullable|max:100',
            'impacto' => 'required|in:bajo,medio,alto,critico',
            'urgencia' => 'required|in:bajo,medio,alto,critico',
            'prioridad' => 'nullable|in:baja,media,alta,critica',
            'id_usuario_asignado' => 'nullable|exists:usuarios,id_usuario',
        ]);

        $datos = $request->only([
            'titulo',
            'descripcion',
            'estado',
            'modulo_afectado',
            'categoria',
            'impacto',
            'urgencia',
            'id_usuario_asignado',
        ]);
        $datos['prioridad'] = $request->prioridad ?: IncidenciaModel::calcularPrioridad($request->impacto, $request->urgencia);

        if ($request->estado === 'cerrado' && $incidencia->estado !== 'cerrado') {
            $datos['id_usuario_cierre'] = session('id_usuario') ?? 1;
            $datos['fecha_cierre'] = now();
        }

        if ($request->estado !== 'cerrado') {
            $datos['id_usuario_cierre'] = null;
            $datos['fecha_cierre'] = null;
        }

        $incidencia->update($datos);

        return redirect()->route('incidencias.show', $id)->with('success', 'Incidencia actualizada');
    }

    public function comentar(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required',
            'enviar_correo' => 'nullable|boolean',
        ]);

        $incidencia = IncidenciaModel::findOrFail($id);

        $comentario = IncidenciaComentarioModel::create([
            'id_incidencia' => $id,
            'id_usuario' => session('id_usuario') ?? 1,
            'comentario' => $request->comentario,
            'tipo' => $request->boolean('enviar_correo') ? 'respuesta' : 'comentario',
        ]);

        if ($request->boolean('enviar_correo')) {
            // Enviamos siempre al correo real de quien reporto la incidencia.
            // Solo usamos la casilla de respaldo si la incidencia no tiene
            // un correo de remitente registrado (p. ej. creada manualmente).
            $destino = $incidencia->correo_remitente
                ?: config('services.soporte.destino_desarrollo', 'danielhuamanflores@hotmail.com');

            Mail::to($destino)->send(new IncidenciaRespuestaMail($incidencia, $comentario));

            $comentario->update([
                'enviado_por_correo' => true,
                'correo_destino' => $destino,
                'fecha_envio_correo' => now(),
            ]);
        }

        return redirect()->route('incidencias.show', $id)->with('success', 'Respuesta registrada');
    }

    public function importarCorreos(IncidenciaCorreoImporter $importer)
    {
        try {
            $total = $importer->importar();
        } catch (\Throwable $e) {
            return redirect()->route('incidencias.index')->with('error', $e->getMessage());
        }

        return redirect()->route('incidencias.index')->with('success', "Correos importados: {$total}");
    }

    public function destroy($id)
    {
        IncidenciaModel::findOrFail($id)->delete();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada');
    }

    private function usuariosResponsables()
    {
        return UsuarioModel::whereIn('rol', [1, 2])->orderBy('username')->get();
    }

    private function catalogos(): array
    {
        return [
            'estados' => $this->estados,
            'prioridades' => $this->prioridades,
            'niveles' => $this->niveles,
            'modulos' => $this->modulos,
            'categorias' => $this->categorias,
        ];
    }
}