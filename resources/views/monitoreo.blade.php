@include('layouts.header')

<style>

.main{
    flex:1;
    padding:30px;
    background:#f4f6fa;
    min-height:100vh;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topbar h1{
    color:#6c3ce9;
    font-size:30px;
    margin:0;
}

.subtitle{
    color:#777;
    margin-top:5px;
    font-size:14px;
}

/* HEADER */
.page-header{
    background:linear-gradient(135deg,#0d6efd,#003e8a);
    color:white;
    padding:25px;
    border-radius:15px;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.page-header h2{
    font-weight:bold;
    margin:0;
    font-size:24px;
}

.page-header p{
    margin:5px 0 0;
    opacity:.85;
    font-size:14px;
}

.btn-actualizar{
    background:rgba(255,255,255,.2);
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-size:14px;
    transition:.2s;
}

.btn-actualizar:hover{
    background:rgba(255,255,255,.35);
}

/* STATS CARDS */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    transition:.25s;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-card h6{
    margin:0 0 5px;
    color:#777;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.stat-number{
    font-size:30px;
    font-weight:bold;
    color:#333;
}

.stat-number.green{color:#28a745;}
.stat-number.yellow{color:#ffc107;}
.stat-number.red{color:#dc3545;}

.stat-icon{
    width:60px;
    height:60px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:25px;
    color:white;
    flex-shrink:0;
}

.stat-icon.blue{background:#0d6efd;}
.stat-icon.green{background:#28a745;}
.stat-icon.yellow{background:#ffc107;}
.stat-icon.red{background:#dc3545;}

/* FILTER CARD */
.filter-card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.filter-row{
    display:flex;
    gap:15px;
    align-items:center;
    flex-wrap:wrap;
}

.filter-row input,
.filter-row select{
    padding:10px 15px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:14px;
    outline:none;
    background:#fff;
    transition:.2s;
}

.filter-row input:focus,
.filter-row select:focus{
    border-color:#0d6efd;
    box-shadow:0 0 0 3px rgba(13,110,253,.15);
}

.filter-row input[type=text]{flex:2;min-width:180px;}
.filter-row select{flex:1;min-width:120px;}
.filter-row input[type=date]{flex:1;min-width:140px;}

.btn-buscar{
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:10px 25px;
    border-radius:10px;
    cursor:pointer;
    font-size:14px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:.2s;
    white-space:nowrap;
}

.btn-buscar:hover{
    background:#0b5ed7;
}

/* TABLE CARD */
.table-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    overflow:hidden;
}

.table-header{
    background:#0d6efd;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.table-header h5{
    margin:0;
    font-size:16px;
    display:flex;
    align-items:center;
    gap:8px;
}

.table-badge{
    background:rgba(255,255,255,.2);
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
}

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

table thead{
    background:#0d6efd;
    color:white;
}

table th{
    padding:12px 15px;
    text-align:left;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
}

table td{
    padding:12px 15px;
    font-size:13px;
    border-bottom:1px solid #eee;
}

table tbody tr{
    transition:.2s;
}

table tbody tr:hover{
    background:#edf6ff;
}

table tbody tr.row-secondary{background:#f8f9fa;}
table tbody tr.row-success{background:#d4edda;}
table tbody tr.row-info{background:#d1ecf1;}
table tbody tr.row-warning{background:#fff3cd;}
table tbody tr.row-danger{background:#f8d7da;}
table tbody tr.row-dark{background:#343a40;color:white;}

table tbody tr.row-danger td a{color:#fff;}

.tag{
    display:inline-block;
    padding:5px 10px;
    border-radius:8px;
    font-size:11px;
    font-weight:600;
    white-space:nowrap;
}

.tag-secondary{background:#6c757d;color:white;}
.tag-success{background:#28a745;color:white;}
.tag-info{background:#17a2b8;color:white;}
.tag-warning{background:#ffc107;color:#333;}
.tag-danger{background:#dc3545;color:white;}
.tag-dark{background:#343a40;color:white;}
.tag-primary{background:#0d6efd;color:white;}

.tag-light{
    background:#f0f0f0;
    color:#666;
    font-weight:400;
}

.msg-preview{
    color:#555;
    max-width:400px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.btn-ver{
    background:#0d6efd;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:8px;
    cursor:pointer;
    font-size:13px;
    transition:.2s;
}

.btn-ver:hover{
    background:#0b5ed7;
}

/* TABLE FOOTER */
.table-footer{
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.table-footer small{
    color:#999;
    font-size:13px;
}

.pagination{
    display:flex;
    gap:5px;
    list-style:none;
    margin:0;
    padding:0;
}

.pagination li a,
.pagination li span{
    display:flex;
    align-items:center;
    justify-content:center;
    min-width:36px;
    height:36px;
    padding:0 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    color:#0d6efd;
    background:#fff;
    border:1px solid #dee2e6;
    transition:.2s;
}

.pagination li a:hover{
    background:#e9ecef;
}

.pagination li.active span{
    background:#0d6efd;
    color:white;
    border-color:#0d6efd;
}

.pagination li.disabled span{
    color:#999;
    cursor:not-allowed;
    opacity:.5;
}

/* MODAL */
.modal-overlay{
    display:none;
    position:fixed;
    top:0;left:0;right:0;bottom:0;
    background:rgba(0,0,0,.5);
    z-index:1000;
    align-items:center;
    justify-content:center;
}

.modal-overlay:target{
    display:flex;
}

.modal-box{
    background:#fff;
    border-radius:15px;
    width:90%;
    max-width:900px;
    max-height:90vh;
    display:flex;
    flex-direction:column;
    box-shadow:0 20px 60px rgba(0,0,0,.3);
    overflow:hidden;
}

.modal-header{
    background:#343a40;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.modal-header h5{
    margin:0;
    font-size:16px;
    display:flex;
    align-items:center;
    gap:8px;
}

.modal-close{
    color:rgba(255,255,255,.7);
    text-decoration:none;
    font-size:24px;
    line-height:1;
    transition:.2s;
}

.modal-close:hover{
    color:white;
}

.modal-body{
    padding:20px;
    overflow-y:auto;
    flex:1;
}

.modal-info{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin-bottom:15px;
}

.modal-info strong{
    display:block;
    color:#666;
    font-size:12px;
    text-transform:uppercase;
    margin-bottom:5px;
}

.modal-info span{
    color:#333;
    font-size:14px;
}

.modal-divider{
    border:none;
    border-top:1px solid #eee;
    margin:15px 0;
}

.modal-mensaje{
    background:#1e1e1e;
    color:#28a745;
    padding:15px;
    border-radius:10px;
    max-height:500px;
    overflow:auto;
    font-size:13px;
    line-height:1.5;
    white-space:pre-wrap;
    word-break:break-word;
    font-family:monospace;
}

<<<<<<< HEAD
/* GRAVEDAD */
.gravedad-bar{display:flex;gap:2px;}
.gravedad-bar span{width:10px;height:14px;border-radius:2px;}

/* SOLUTION COLLAPSE */
details summary{cursor:pointer;padding:5px 0;}
details summary::-webkit-details-marker{color:#0d6efd;}
details .sol-box{background:#e8f5e9;padding:15px;border-radius:10px;margin-top:10px;border-left:4px solid #2e7d32;}

=======
>>>>>>> dev
/* ACTUALIZAR BOTTOM */
.bottom-actions{
    text-align:center;
    margin-top:25px;
}

/* EMPTY STATE */
.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#999;
}

.empty-state i{
    font-size:60px;
    display:block;
    margin-bottom:15px;
}

.empty-state h4{
    margin:0;
    color:#666;
}

@media(max-width:900px){
    .stats-grid{
        grid-template-columns:repeat(2,1fr);
    }
    .modal-info{
        grid-template-columns:1fr;
    }
}

@media(max-width:600px){
    .stats-grid{
        grid-template-columns:1fr;
    }
    .filter-row{
        flex-direction:column;
    }
    .filter-row input,
    .filter-row select{
        width:100%;
    }
    .main{
        padding:15px;
    }
    .page-header{
        flex-direction:column;
        text-align:center;
        gap:15px;
    }
}

</style>

<div class="main">

<div class="page-header">
<div>
<h2><i class="fa fa-microchip"></i> Centro de Monitoreo</h2>
<p>Monitoreo de eventos registrados por Monolog</p>
</div>
<a href="{{ route('monitoreo') }}" class="btn-actualizar"><i class="fa fa-refresh"></i> Actualizar</a>
</div>

<!-- STATS -->
<div class="stats-grid">

<div class="stat-card">
<div>
<h6>Total Eventos</h6>
<div class="stat-number">{{ $estadisticas['total'] }}</div>
</div>
<div class="stat-icon blue"><i class="fa fa-list"></i></div>
</div>

<div class="stat-card">
<div>
<h6>INFO</h6>
<div class="stat-number green">{{ $estadisticas['info'] }}</div>
</div>
<div class="stat-icon green"><i class="fa fa-check-circle"></i></div>
</div>

<div class="stat-card">
<div>
<h6>WARNING</h6>
<div class="stat-number yellow">{{ $estadisticas['warning'] }}</div>
</div>
<div class="stat-icon yellow"><i class="fa fa-exclamation-triangle"></i></div>
</div>

<div class="stat-card">
<div>
<h6>ERROR</h6>
<div class="stat-number red">{{ $estadisticas['error'] }}</div>
</div>
<div class="stat-icon red"><i class="fa fa-times-circle"></i></div>
</div>

</div>

<!-- FILTROS -->
<div class="filter-card">
<form method="GET">
<div class="filter-row">
<input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar mensaje...">
<<<<<<< HEAD
        <select name="nivel">
            <option value="">Todos</option>
            <option value="EMERGENCY">EMERGENCY — Toda la app inutilizable</option>
            <option value="ALERT">ALERT — Intervención inmediata</option>
            <option value="CRITICAL">CRITICAL — Parte esencial afectada</option>
            <option value="ERROR">ERROR — App funciona parcialmente</option>
            <option value="WARNING">WARNING — Situación anormal</option>
            <option value="NOTICE">NOTICE — Evento esperado</option>
            <option value="INFO">INFO — Informativo</option>
            <option value="DEBUG">DEBUG — Depuración</option>
        </select>
=======
<select name="nivel">
<option value="">Todos</option>
<option value="INFO">INFO</option>
<option value="NOTICE">NOTICE</option>
<option value="DEBUG">DEBUG</option>
<option value="WARNING">WARNING</option>
<option value="ERROR">ERROR</option>
<option value="CRITICAL">CRITICAL</option>
<option value="ALERT">ALERT</option>
<option value="EMERGENCY">EMERGENCY</option>
</select>
>>>>>>> dev
<input type="date" name="fecha" value="{{ request('fecha') }}">
<button class="btn-buscar"><i class="fa fa-search"></i> Buscar</button>
</div>
</form>
</div>

<!-- TABLA -->
<div class="table-card">

<div class="table-header">
<h5><i class="fa fa-book"></i> Registro de Eventos</h5>
<span class="table-badge">{{ $eventos->total() }} eventos</span>
</div>

<div class="table-wrap">
<table>
<thead>
<tr>
<<<<<<< HEAD
            <th>#</th>
            <th>Fecha</th>
            <th>Nivel</th>
            <th>Gravedad</th>
            <th>Canal</th>
            <th>Descripción</th>
            <th>Mensaje</th>
            <th>Acción</th>
=======
<th>#</th>
<th>Fecha</th>
<th>Nivel</th>
<th>Canal</th>
<th>Mensaje</th>
<th>Acción</th>
>>>>>>> dev
</tr>
</thead>
<tbody>

@forelse($eventos as $evento)

@php
$nivel = strtoupper($evento['nivel']);
$fila='';
switch($nivel){
case 'DEBUG': $fila='row-secondary'; break;
case 'INFO': $fila='row-success'; break;
case 'NOTICE': $fila='row-info'; break;
case 'WARNING': $fila='row-warning'; break;
case 'ERROR': $fila='row-danger'; break;
case 'CRITICAL': $fila='row-dark'; break;
case 'ALERT': $fila='row-secondary'; break;
case 'EMERGENCY': $fila='row-danger'; break;
}

$tag='';
switch($nivel){
case 'DEBUG': $tag='tag-secondary'; break;
case 'INFO': $tag='tag-success'; break;
case 'NOTICE': $tag='tag-info'; break;
case 'WARNING': $tag='tag-warning'; break;
case 'ERROR': $tag='tag-danger'; break;
case 'CRITICAL': $tag='tag-dark'; break;
case 'ALERT': $tag='tag-primary'; break;
case 'EMERGENCY': $tag='tag-danger'; break;
}
@endphp

<tr class="{{ $fila }}">
<td>{{ $loop->iteration + (($eventos->currentPage()-1) * $eventos->perPage()) }}</td>
<td><i class="fa fa-clock"></i> {{ $evento['fecha'] }}</td>
<<<<<<< HEAD
<td><span class="tag {{ $tag }}" title="{{ $evento['nivel_desc'] }}">{{ $evento['nivel_nombre'] }}</span></td>
<td>
@php $g = $evento['gravedad']; @endphp
@for($i=1;$i<=8;$i++)
<span style="color:{{ $i <= $g ? '#dc3545' : '#ddd' }};">&#9608;</span>
@endfor
</td>
<td><span class="tag tag-light">{{ $evento['canal'] }}</span></td>
<td><i class="fa fa-info-circle"></i> {{ $evento['descripcion'] }}</td>
=======
<td><span class="tag {{ $tag }}">{{ $nivel }}</span></td>
<td><span class="tag tag-light">{{ $evento['canal'] }}</span></td>
>>>>>>> dev
<td class="msg-preview">{{ \Illuminate\Support\Str::limit($evento['mensaje'],120) }}</td>
<td><a href="#detalle{{$loop->index}}" class="btn-ver"><i class="fa fa-eye"></i></a></td>
</tr>

@empty

<tr>
<<<<<<< HEAD
<td colspan="8" style="text-align:center;padding:60px 20px;color:#999;">
=======
<td colspan="6" style="text-align:center;padding:60px 20px;color:#999;">
>>>>>>> dev
<i class="fa fa-database" style="font-size:60px;display:block;margin-bottom:15px;"></i>
<h4 style="margin:0;color:#666;">No existen eventos registrados</h4>
</td>
</tr>

@endforelse

</tbody>
</table>
</div>

<div class="table-footer">
<small>Mostrando {{ $eventos->firstItem() ?? 0 }} - {{ $eventos->lastItem() ?? 0 }} de {{ $eventos->total() }} eventos</small>
{{ $eventos->withQueryString()->links('pagination::bootstrap-5') }}
</div>

</div>

<div class="bottom-actions">
<a href="{{ route('monitoreo') }}" class="btn-actualizar" style="background:#0d6efd;color:white;display:inline-flex;"><i class="fa fa-refresh"></i> Actualizar</a>
</div>

</div>

<!-- MODALES -->
@foreach($eventos as $evento)
<div class="modal-overlay" id="detalle{{$loop->index}}">
<div class="modal-box">
<div class="modal-header">
<h5><i class="fa fa-terminal"></i> Detalle del Evento</h5>
<a href="#" class="modal-close">&times;</a>
</div>
<div class="modal-body">
<div class="modal-info">
<div><strong>Fecha</strong><span>{{ $evento['fecha'] }}</span></div>
<div><strong>Canal</strong><span>{{ $evento['canal'] }}</span></div>
<<<<<<< HEAD
<div><strong>Nivel</strong><span class="tag {{ $tag }}">{{ $evento['nivel_nombre'] }} ({{ $evento['nivel'] }})</span></div>
<div><strong>Gravedad</strong><span>
@php $g = $evento['gravedad']; @endphp
@for($i=1;$i<=8;$i++)
<span style="color:{{ $i <= $g ? '#dc3545' : '#ddd' }};font-size:18px;">&#9608;</span>
@endfor
({{ $g }}/8)
</span></div>
<div><strong>Descripción</strong><span>{{ $evento['nivel_desc'] }}</span></div>
<div><strong>Clasificación</strong><span>{{ $evento['descripcion'] }}</span></div>
=======
<div><strong>Nivel</strong><span>{{ $evento['nivel'] }}</span></div>
>>>>>>> dev
</div>
<hr class="modal-divider">
<strong style="display:block;margin-bottom:10px;">Mensaje completo</strong>
<div class="modal-mensaje">{{ $evento['mensaje'] }}</div>
<<<<<<< HEAD

@if($evento['solucion']['solucion'])
<hr class="modal-divider">
<details style="margin-top:10px;">
<summary style="cursor:pointer;color:#0d6efd;font-weight:600;font-size:14px;"><i class="fa fa-lightbulb"></i> ¿Cómo solucionarlo?</summary>
<div style="background:#e8f5e9;padding:15px;border-radius:10px;margin-top:10px;">
<p style="margin:0 0 10px 0;color:#2e7d32;"><strong>Solución:</strong> {{ $evento['solucion']['solucion'] }}</p>
@if(count($evento['solucion']['acciones']) > 0)
<strong style="color:#2e7d32;">Acciones de mejora:</strong>
<ol style="margin:8px 0 0 0;padding-left:20px;">
@foreach($evento['solucion']['acciones'] as $accion)
<li style="color:#333;margin-bottom:4px;">{{ $accion }}</li>
@endforeach
</ol>
@endif
</div>
</details>
@endif

=======
>>>>>>> dev
</div>
</div>
</div>
@endforeach

</body>
</html>
