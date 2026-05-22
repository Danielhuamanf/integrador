@include('layouts.header')

<style>

.main{
flex:1;
padding:25px;
}

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
flex-wrap:wrap;
gap:10px;
}

.topbar h2{
color:#6c3ce9;
}

.btn-back{
background:#6c3ce9;
color:white;
padding:10px 18px;
border-radius:10px;
text-decoration:none;
}

.card{
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 12px rgba(0,0,0,0.05);
overflow:auto;
}

table{
width:100%;
border-collapse:collapse;
min-width:1200px;
}

th{
padding:15px 10px;
text-align:left;
background:#fafafa;
color:#777;
font-size:14px;
}

td{
padding:15px 10px;
border-top:1px solid #eee;
font-size:14px;
}

tr:hover{
background:#fafafa;
}

.estado{
padding:6px 12px;
border-radius:20px;
font-size:12px;
font-weight:bold;
display:inline-block;
}

.pendiente{
background:#fff3cd;
color:#856404;
}

.almacen{
background:#d4edda;
color:#155724;
}

</style>

<div class="main">

<div class="topbar">

<h2>
Envíos del almacén:
{{ $almacen->nombre_almacen }}
</h2>

<a href="{{ url('/almacen') }}"
class="btn-back">

Volver

</a>

</div>

<div class="card">

<table>

<thead>

<tr>

<th>ID</th>
<th>Descripción</th>
<th>Peso</th>
<th>Volumen</th>
<th>Valor</th>
<th>Tipo</th>
<th>Estado</th>
<th>Fecha Envío</th>
<th>Fecha Entrega</th>
<th>Total</th>

</tr>

</thead>

<tbody>

@forelse($productos as $p)

<tr>

<td>
{{ $p->id_envio }}
</td>

<td>
{{ $p->descripcion }}
</td>

<td>
{{ $p->peso }}
</td>

<td>
{{ $p->volumen }}
</td>

<td>
S/. {{ $p->valor_declarado }}
</td>

<td>
{{ $p->tipo_envio }}
</td>

<td>

@if($p->estado == 'pendiente')

<span class="estado pendiente">
Pendiente
</span>

@else

<span class="estado almacen">
En almacén
</span>

@endif

</td>

<td>
{{ $p->fecha_envio }}
</td>

<td>
{{ $p->fecha_entrega }}
</td>

<td>
S/. {{ $p->total_real }}
</td>

</tr>

@empty

<tr>

<td colspan="10" style="text-align:center;">

No hay envíos en este almacén

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</body>
</html>