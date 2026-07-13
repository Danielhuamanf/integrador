@include('layouts.header')
<style>
.main{flex:1;padding:30px;background:#f4f6fa;min-height:100vh;}
.topbar{margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
.topbar h1{color:#4b2ad6;font-size:24px;margin:0;}
.topbar a{color:#4b2ad6;text-decoration:none;font-size:14px;}
.grid-2{display:grid;grid-template-columns:2fr 1fr;gap:20px;}
.card{background:#fff;border-radius:12px;box-shadow:0 5px 18px rgba(0,0,0,.08);overflow:hidden;margin-bottom:20px;}
.card-header{background:#4b2ad6;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center;}
.card-body{padding:20px;}
.info-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:15px;}
.info-item label{display:block;font-size:11px;text-transform:uppercase;color:#888;margin-bottom:3px;}
.info-item strong{font-size:14px;color:#333;word-break:break-word;}
.tag{display:inline-block;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;}
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
.desc-box{background:#f9f9f9;border-radius:10px;padding:15px;margin-top:14px;font-size:14px;line-height:1.6;color:#444;white-space:pre-wrap;}
.comentario{border-left:3px solid #4b2ad6;padding:12px 15px;margin-bottom:12px;background:#fafafa;border-radius:0 8px 8px 0;}
.comentario .meta{font-size:12px;color:#888;margin-bottom:5px;}
.comentario .meta strong{color:#4b2ad6;}
.comentario .texto{font-size:14px;color:#444;line-height:1.5;white-space:pre-wrap;}
.form-comment textarea,.quick-form select{width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;outline:none;font-family:inherit;}
.form-comment textarea{min-height:90px;resize:vertical;margin-bottom:10px;}
.check-row{display:flex;align-items:center;gap:8px;margin:4px 0 12px;font-size:13px;color:#555;}
.btn-primary,.btn-secondary,.btn-danger{border:none;padding:9px 18px;border-radius:8px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-primary{background:#4b2ad6;color:#fff;}
.btn-secondary{background:#fff;color:#666;border:1px solid #ddd;}
.btn-danger{background:#dc3545;color:#fff;}
.msg-success,.msg-error{padding:12px 18px;border-radius:10px;margin-bottom:15px;display:flex;align-items:center;gap:8px;}
.msg-success{background:#d4edda;color:#155724;}
.msg-error{background:#f8d7da;color:#721c24;}
.action-buttons{display:flex;gap:8px;flex-wrap:wrap;}
.empty-state{text-align:center;padding:32px;color:#999;}
@media(max-width:850px){.grid-2{grid-template-columns:1fr;}.info-grid{grid-template-columns:1fr;}.main{padding:15px;}}
</style>

<div class="main">
    <div class="topbar">
        <div>
            <h1><i class="fa fa-ticket"></i> {{ $incidencia->codigo ?? ('#'.$incidencia->id_incidencia) }}</h1>
            <a href="{{ route('incidencias.index') }}"><i class="fa fa-arrow-left"></i> Volver a incidencias</a>
        </div>
        <div class="action-buttons">
            <a href="{{ route('incidencias.edit', $incidencia->id_incidencia) }}" class="btn-primary"><i class="fa fa-pencil"></i> Editar</a>
            <form method="POST" action="{{ route('incidencias.destroy', $incidencia->id_incidencia) }}" onsubmit="return confirm('Eliminar esta incidencia?')" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="msg-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="msg-error"><i class="fa fa-triangle-exclamation"></i> {{ session('error') }}</div>
    @endif

    <div class="grid-2">
        <div>
            <div class="card">
                <div class="card-header"><strong><i class="fa fa-info-circle"></i> Detalle</strong></div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item"><label>Asunto</label><strong>{{ $incidencia->titulo }}</strong></div>
                        <div class="info-item"><label>Origen</label><strong>{{ ucfirst($incidencia->origen ?? 'manual') }}</strong></div>
                        <div class="info-item"><label>Estado</label><strong><span class="tag tag-{{ $incidencia->estado }}">{{ $estados[$incidencia->estado] ?? ucfirst(str_replace('_',' ', $incidencia->estado)) }}</span></strong></div>
                        <div class="info-item"><label>Prioridad</label><strong><span class="tag tag-{{ $incidencia->prioridad }}">{{ $prioridades[$incidencia->prioridad] ?? ucfirst($incidencia->prioridad) }}</span></strong></div>
                        <div class="info-item"><label>Remitente</label><strong>{{ $incidencia->remitente ?? '-' }}</strong></div>
                        <div class="info-item"><label>Correo</label><strong>{{ $incidencia->correo_remitente ?? '-' }}</strong></div>
                        <div class="info-item"><label>Usuario asociado</label><strong>{{ $incidencia->creador->username ?? '-' }}</strong></div>
                        <div class="info-item"><label>Responsable</label><strong>{{ $incidencia->asignado->username ?? '-' }}</strong></div>
                        <div class="info-item"><label>Modulo</label><strong>{{ $modulos[$incidencia->modulo_afectado] ?? ($incidencia->modulo_afectado ?: '-') }}</strong></div>
                        <div class="info-item"><label>Categoria</label><strong>{{ $categorias[$incidencia->categoria] ?? ($incidencia->categoria ?: '-') }}</strong></div>
                        <div class="info-item"><label>Impacto</label><strong>{{ $niveles[$incidencia->impacto] ?? '-' }}</strong></div>
                        <div class="info-item"><label>Urgencia</label><strong>{{ $niveles[$incidencia->urgencia] ?? '-' }}</strong></div>
                        <div class="info-item"><label>Recepcion</label><strong>{{ $incidencia->fecha_recepcion ? $incidencia->fecha_recepcion->format('d/m/Y H:i') : '-' }}</strong></div>
                        <div class="info-item"><label>Cierre</label><strong>{{ $incidencia->fecha_cierre ? $incidencia->fecha_cierre->format('d/m/Y H:i') : '-' }} {{ $incidencia->cerradoPor ? 'por '.$incidencia->cerradoPor->username : '' }}</strong></div>
                    </div>
                    <div class="desc-box">{{ $incidencia->descripcion ?? 'Sin descripcion' }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong><i class="fa fa-comments"></i> Respuestas y comentarios ({{ $incidencia->comentarios->count() }})</strong></div>
                <div class="card-body">
                    @forelse($incidencia->comentarios as $c)
                    <div class="comentario">
                        <div class="meta">
                            <strong>{{ $c->usuario->username ?? 'Usuario' }}</strong>
                            &middot; {{ \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i') }}
                            @if($c->enviado_por_correo)
                            &middot; enviado a {{ $c->correo_destino }}
                            @endif
                        </div>
                        <div class="texto">{{ $c->comentario }}</div>
                    </div>
                    @empty
                    <div class="empty-state"><i class="fa fa-comment-o" style="font-size:28px;display:block;margin-bottom:10px;"></i> Sin respuestas aun</div>
                    @endforelse

                    <hr style="border:none;border-top:1px solid #eee;margin:15px 0;">

                    <form class="form-comment" method="POST" action="{{ route('incidencias.comentar', $incidencia->id_incidencia) }}">
                        @csrf
                        <textarea name="comentario" placeholder="Escribe una respuesta o comentario interno..." required></textarea>
                        <label class="check-row">
                            <input type="checkbox" name="enviar_correo" value="1">
                            Enviar tambien por correo al remitente
                        </label>
                        <button class="btn-primary"><i class="fa fa-send"></i> Registrar respuesta</button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header"><strong><i class="fa fa-route"></i> Flujo</strong></div>
                <div class="card-body">
                    <form class="quick-form" method="POST" action="{{ route('incidencias.update', $incidencia->id_incidencia) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="titulo" value="{{ $incidencia->titulo }}">
                        <input type="hidden" name="descripcion" value="{{ $incidencia->descripcion }}">
                        <input type="hidden" name="modulo_afectado" value="{{ $incidencia->modulo_afectado }}">
                        <input type="hidden" name="categoria" value="{{ $incidencia->categoria }}">
                        <input type="hidden" name="impacto" value="{{ $incidencia->impacto ?: 'medio' }}">
                        <input type="hidden" name="urgencia" value="{{ $incidencia->urgencia ?: 'medio' }}">
                        <input type="hidden" name="prioridad" value="{{ $incidencia->prioridad }}">
                        <input type="hidden" name="id_usuario_asignado" value="{{ $incidencia->id_usuario_asignado }}">
                        <div style="margin-bottom:12px;">
                            <label style="display:block;font-size:12px;color:#888;margin-bottom:4px;">Cambiar estado</label>
                            <select name="estado">
                                @foreach($estados as $valor => $texto)
                                <option value="{{ $valor }}" {{ $incidencia->estado==$valor?'selected':'' }}>{{ $texto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn-primary" style="width:100%;justify-content:center;"><i class="fa fa-refresh"></i> Actualizar Estado</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong><i class="fa fa-user-check"></i> Clasificacion</strong></div>
                <div class="card-body">
                    <div style="font-size:13px;line-height:1.8;color:#555;">
                        <div>Correo recibido</div>
                        <div>Creacion automatica</div>
                        <div>Pendiente</div>
                        <div>Clasificacion</div>
                        <div>Asignacion</div>
                        <div>En diagnostico</div>
                        <div>En resolucion</div>
                        <div>Validacion</div>
                        <div>Cerrado</div>
                    </div>
                    <a href="{{ route('incidencias.edit', $incidencia->id_incidencia) }}" class="btn-secondary" style="margin-top:14px;width:100%;justify-content:center;"><i class="fa fa-sliders"></i> Clasificar incidencia</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
