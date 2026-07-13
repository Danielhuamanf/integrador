<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DocumentosModel;
use App\Models\EnvioModel;

class DocumentosController extends Controller
{
   public function index()
    {
        $documentos = DocumentosModel::with('envio')
            ->orderBy('id_documento', 'desc')
            ->get();

        $envios = EnvioModel::orderBy('id_envio', 'desc')->get();

        $data = ['url' => 'documentos'];

        return view(
            'admin.documentos_list',
            compact('documentos', 'envios', 'data')
        );
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'id_envio'        => 'required',
            'nombre_doc'      => 'required|max:255',
            'descripcion_doc' => 'nullable|max:255',
            'archivo'         => 'required|file|max:5120'
        ]);

        $rutaArchivo = null;

        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request
                ->file('archivo')
                ->store('documentos', 'public');
        }

        DocumentosModel::create([
            'id_envio'        => $request->id_envio,
            'nombre_doc'      => $request->nombre_doc,
            'url_documento'   => $rutaArchivo,
            'descripcion_doc' => $request->descripcion_doc,
            'created_at'      => now(),
        ]);

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento registrado correctamente');
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update(Request $request, $id)
    {
        $documento = DocumentosModel::find($id);

        if (!$documento) {
            return redirect()
                ->route('documentos.index')
                ->with('error', 'Documento no encontrado');
        }

        $request->validate([
            'id_envio'        => 'required',
            'nombre_doc'      => 'required|max:255',
            'descripcion_doc' => 'nullable|max:255',
            'archivo'         => 'nullable|file|max:5120'
        ]);

        $rutaArchivo = $documento->url_documento;

        // reemplazar archivo si suben otro
        if ($request->hasFile('archivo')) {

            if (
                $documento->url_documento &&
                Storage::disk('public')->exists($documento->url_documento)
            ) {
                Storage::disk('public')->delete(
                    $documento->url_documento
                );
            }

            $rutaArchivo = $request
                ->file('archivo')
                ->store('documentos', 'public');
        }

        $documento->update([
            'id_envio'        => $request->id_envio,
            'nombre_doc'      => $request->nombre_doc,
            'url_documento'   => $rutaArchivo,
            'descripcion_doc' => $request->descripcion_doc,
        ]);

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento actualizado correctamente');
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        $documento = DocumentosModel::find($id);

        if (!$documento) {
            return redirect()
                ->route('documentos.index')
                ->with('error', 'Documento no encontrado');
        }

        // borrar archivo físico
        if (
            $documento->url_documento &&
            Storage::disk('public')->exists($documento->url_documento)
        ) {
            Storage::disk('public')->delete(
                $documento->url_documento
            );
        }

        $documento->delete();

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento eliminado correctamente');
    }

    // =========================
    // VER ARCHIVO
    // =========================
    public function ver($id)
    {
        $documento = DocumentosModel::findOrFail($id);

        $ruta = storage_path(
            'app/public/' . $documento->url_documento
        );

        return response()->file($ruta);
    }

    // =========================
    // DESCARGAR ARCHIVO
    // =========================
    public function download($id)
    {
        $documento = DocumentosModel::findOrFail($id);

        $ruta = storage_path(
            'app/public/' . $documento->url_documento
        );

        return response()->download($ruta);
    }

}