@include('layouts.header')
<style>
.main{flex:1;padding:30px;background:#f4f6fa;min-height:100vh;}
.topbar{margin-bottom:22px;}
.topbar h1{color:#4b2ad6;font-size:26px;margin:0;}
.topbar a{color:#4b2ad6;text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:5px;margin-top:5px;}
.card{background:#fff;border-radius:12px;box-shadow:0 5px 18px rgba(0,0,0,.08);padding:28px;max-width:920px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{margin-bottom:16px;}
.form-group label{display:block;font-weight:600;font-size:13px;color:#444;margin-bottom:6px;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;outline:none;background:#fff;font-family:inherit;}
.form-group textarea{min-height:130px;resize:vertical;}
.btn-primary,.btn-secondary{padding:11px 24px;border-radius:10px;font-size:14px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
.btn-primary{background:#4b2ad6;color:#fff;border:none;}
.btn-secondary{background:#fff;color:#666;border:1px solid #ddd;}
.error{background:#f8d7da;color:#721c24;padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;}
@media(max-width:760px){.main{padding:15px;}.form-row{grid-template-columns:1fr;}}
</style>

<div class="main">
    <div class="topbar">
        <h1><i class="fa fa-pencil"></i> Editar {{ $incidencia->codigo ?? ('#'.$incidencia->id_incidencia) }}</h1>
        <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>

    <div class="card">
        @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('incidencias.update', $incidencia->id_incidencia) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label>Asunto *</label>
                <input type="text" name="titulo" required maxlength="200" value="{{ old('titulo', $incidencia->titulo) }}">
            </div>

            <div class="form-group">
                <label>Descripcion</label>
                <textarea name="descripcion">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Estado *</label>
                    <select name="estado" required>
                        @foreach($estados as $valor => $texto)
                        <option value="{{ $valor }}" {{ old('estado', $incidencia->estado)==$valor?'selected':'' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Responsable</label>
                    <select name="id_usuario_asignado">
                        <option value="">Sin asignar</option>
                        @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}" {{ old('id_usuario_asignado', $incidencia->id_usuario_asignado)==$u->id_usuario?'selected':'' }}>{{ $u->username }} ({{ $u->correo }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Modulo afectado</label>
                    <select name="modulo_afectado">
                        <option value="">Sin modulo</option>
                        @foreach($modulos as $valor => $texto)
                        <option value="{{ $valor }}" {{ old('modulo_afectado', $incidencia->modulo_afectado)==$valor?'selected':'' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria">
                        <option value="">Sin categoria</option>
                        @foreach($categorias as $valor => $texto)
                        <option value="{{ $valor }}" {{ old('categoria', $incidencia->categoria)==$valor?'selected':'' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Impacto *</label>
                    <select name="impacto" required>
                        @foreach($niveles as $valor => $texto)
                        <option value="{{ $valor }}" {{ old('impacto', $incidencia->impacto ?: 'medio')==$valor?'selected':'' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Urgencia *</label>
                    <select name="urgencia" required>
                        @foreach($niveles as $valor => $texto)
                        <option value="{{ $valor }}" {{ old('urgencia', $incidencia->urgencia ?: 'medio')==$valor?'selected':'' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Prioridad manual</label>
                <select name="prioridad">
                    <option value="">Calcular automaticamente</option>
                    @foreach($prioridades as $valor => $texto)
                    <option value="{{ $valor }}" {{ old('prioridad', $incidencia->prioridad)==$valor?'selected':'' }}>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;gap:12px;margin-top:10px;flex-wrap:wrap;">
                <button class="btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
