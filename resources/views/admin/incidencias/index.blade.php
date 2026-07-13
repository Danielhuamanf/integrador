@include('layouts.header')
<style>
.main{flex:1;padding:30px;background:#f4f6fa;min-height:100vh;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.topbar h1{color:#4b2ad6;font-size:26px;margin:0;}
.actions{display:flex;gap:10px;flex-wrap:wrap;}
.btn-primary,.btn-secondary{border:none;padding:10px 18px;border-radius:10px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-size:13px;transition:.2s;cursor:pointer;}
.btn-primary{background:#4b2ad6;color:#fff;}
.btn-primary:hover{background:#3a1fb0;}
.btn-secondary{background:#fff;color:#4b2ad6;border:1px solid #ddd;}
.btn-secondary:hover{background:#f0ebff;}
.card{background:#fff;border-radius:12px;box-shadow:0 5px 18px rgba(0,0,0,.08);overflow:hidden;}
.card-header{background:#4b2ad6;color:white;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;}
.filter-row{display:grid;grid-template-columns:2fr repeat(4,1fr) auto;gap:10px;margin-bottom:18px;background:#fff;padding:16px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,.05);}
.filter-row input,.filter-row select{padding:9px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px;outline:none;background:#fff;min-width:0;}
table{width:100%;border-collapse:collapse;}
thead{background:#4b2ad6;color:#fff;}
th,td{padding:12px 14px;text-align:left;font-size:13px;border-bottom:1px solid #eee;vertical-align:top;}
tbody tr:hover{background:#f0ebff;}
.tag{display:inline-block;padding:4px 9px;border-radius:6px;font-size:11px;font-weight:600;white-space:nowrap;}
.tag-pendiente{background:#fff3e0;color:#e65100;}
.tag-clasificacion{background:#ede7ff;color:#4b2ad6;}
.tag-asignado{background:#e3f2fd;color:#1565c0;}
.tag-en_diagnostico{background:#e0f7fa;color:#006064;}
.tag-en_resolucion{background:#e8f5e9;color:#2e7d32;}
.tag-validacion{background:#fce4ec;color:#ad1457;}
.tag-cerrado{background:#f3f3f3;color:#666;}
.tag-critica{background:#ffebee;color:#c62828;}
.tag-alta{background:#fff3e0;color:#e65100;}
.tag-media{background:#e8f5e9;color:#2e7d32;}
.tag-baja{background:#e3f2fd;color:#1565c0;}
.btn-sm{background:#fff;border:1px solid #ddd;padding:6px 10px;border-radius:7px;text-decoration:none;color:#555;display:inline-flex;align-items:center;gap:5px;}
.btn-sm:hover{background:#4b2ad6;color:#fff;border-color:#4b2ad6;}
.msg-success,.msg-error{padding:12px 18px;border-radius:10px;margin-bottom:15px;display:flex;align-items:center;gap:8px;}
.msg-success{background:#d4edda;color:#155724;}
.msg-error{background:#f8d7da;color:#721c24;}
.text-muted{color:#888;font-size:12px;}
.footer-card{padding:15px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
@media(max-width:1100px){.filter-row{grid-template-columns:1fr 1fr;}.filter-row button{grid-column:1/-1;justify-content:center;}}
@media(max-width:700px){.main{padding:15px;}.filter-row{grid-template-columns:1fr;}}
</style>

<div class="main">
    <div class="topbar">
        <div>
            <h1><i class="fa fa-headset"></i> Incidencias</h1>
            <div class="text-muted" style="margin-top:5px;">Mesa de ayuda PASOC</div>
        </div>
        <div class="actions">
            <form method="POST" action="{{ route('incidencias.importar') }}">
                @csrf
                <button class="btn-secondary"><i class="fa fa-envelope-open-text"></i> Importar correos</button>
            </form>
            <a href="{{ route('incidencias.create') }}" class="btn-primary"><i class="fa fa-plus"></i> Nueva Incidencia</a>
        </div>
    </div>

    @if(session('success'))
    <div class="msg-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="msg-error"><i class="fa fa-triangle-exclamation"></i> {{ session('error') }}</div>
    @endif

    <form method="GET">
        <div class="filter-row">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Codigo, asunto, remitente o descripcion">
            <select name="estado">
                <option value="">Estados</option>
                @foreach($estados as $valor => $texto)
                <option value="{{ $valor }}" {{ request('estado')==$valor?'selected':'' }}>{{ $texto }}</option>
                @endforeach
            </select>
            <select name="prioridad">
                <option value="">Prioridades</option>
                @foreach($prioridades as $valor => $texto)
                <option value="{{ $valor }}" {{ request('prioridad')==$valor?'selected':'' }}>{{ $texto }}</option>
                @endforeach
            </select>
            <select name="modulo_afectado">
                <option value="">Modulos</option>
                @foreach($modulos as $valor => $texto)
                <option value="{{ $valor }}" {{ request('modulo_afectado')==$valor?'selected':'' }}>{{ $texto }}</option>
                @endforeach
            </select>
            <select name="id_usuario_asignado">
                <option value="">Responsables</option>
                @foreach($usuarios as $u)
                <option value="{{ $u->id_usuario }}" {{ request('id_usuario_asignado')==$u->id_usuario?'selected':'' }}>{{ $u->username }}</option>
                @endforeach
            </select>
            <button class="btn-primary"><i class="fa fa-search"></i> Filtrar</button>
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <strong><i class="fa fa-list"></i> Lista de incidencias</strong>
            <span style="background:rgba(255,255,255,.2);padding:3px 12px;border-radius:20px;font-size:12px;">{{ $incidencias->total() }} registros</span>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Asunto</th>
                        <th>Remitente</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Modulo</th>
                        <th>Responsable</th>
                        <th>Recepcion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incidencias as $i)
                    <tr>
                        <td><strong>{{ $i->codigo ?? ('#'.$i->id_incidencia) }}</strong><div class="text-muted">{{ ucfirst($i->origen ?? 'manual') }}</div></td>
                        <td>{{ $i->titulo }}</td>
                        <td>{{ $i->remitente ?? $i->creador->username ?? 'Sin remitente' }}<div class="text-muted">{{ $i->correo_remitente }}</div></td>
                        <td><span class="tag tag-{{ $i->estado }}">{{ $estados[$i->estado] ?? ucfirst(str_replace('_',' ', $i->estado)) }}</span></td>
                        <td><span class="tag tag-{{ $i->prioridad }}">{{ $prioridades[$i->prioridad] ?? ucfirst($i->prioridad) }}</span></td>
                        <td>{{ $modulos[$i->modulo_afectado] ?? ($i->modulo_afectado ?: '-') }}</td>
                        <td>{{ $i->asignado->username ?? '-' }}</td>
                        <td>{{ $i->fecha_recepcion ? $i->fecha_recepcion->format('d/m/Y H:i') : \Carbon\Carbon::parse($i->created_at)->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('incidencias.show', $i->id_incidencia) }}" class="btn-sm"><i class="fa fa-eye"></i> Ver</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="9" style="text-align:center;padding:45px;color:#999;">No hay incidencias registradas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="footer-card">
            <small class="text-muted">Mostrando {{ $incidencias->firstItem() ?? 0 }} - {{ $incidencias->lastItem() ?? 0 }} de {{ $incidencias->total() }}</small>
            {{ $incidencias->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</body>
</html>
