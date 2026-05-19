<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clientes</title>
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
 
<style>
 
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins', sans-serif;
}
 
body{
background:#f0f4ff;
}
 
.container{
display:flex;
min-height:100vh;
}
 
/* SIDEBAR */
 
.sidebar{
width:240px;
background:#1a1a2e;
padding:20px;
box-shadow:2px 0 10px rgba(0,0,0,0.15);
}
 
.logo{
margin-bottom:30px;
}
 
.menu a{
display:flex;
align-items:center;
gap:12px;
text-decoration:none;
color:#aab4d4;
padding:12px;
border-radius:10px;
margin-bottom:8px;
transition: all 0.2s;
}
 
.menu a.active,
.menu a:hover{
background:#2563eb;
color:#fff;
}
 
/* MAIN */
 
.main{
flex:1;
padding:25px;
}
 
.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}
 
.topbar h2{
color:#1a1a2e;
font-size:22px;
font-weight:600;
}
 
.right-top{
display:flex;
gap:10px;
}
 
.search{
padding:10px 15px;
border-radius:20px;
border:1px solid #ddd;
width:250px;
outline:none;
font-family:'Poppins', sans-serif;
}
 
.btn-new{
background:#2563eb;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
font-size:14px;
font-family:'Poppins', sans-serif;
transition: background 0.2s;
}
 
.btn-new:hover{
background:#1d4ed8;
}
 
/* CARD */
 
.card{
background:#fff;
border-radius:14px;
padding:20px;
box-shadow:0 4px 16px rgba(37,99,235,0.07);
}
 
/* TABLE */
 
table{
width:100%;
border-collapse:collapse;
}
 
th{
text-align:left;
padding:15px 10px;
color:#94a3b8;
font-size:13px;
font-weight:500;
text-transform:uppercase;
letter-spacing:0.05em;
}
 
td{
padding:15px 10px;
border-top:1px solid #f1f5f9;
font-size:14px;
color:#475569;
}
 
tr:hover td{
background:#f8faff;
}
 
.user{
display:flex;
align-items:center;
gap:10px;
}
 
.avatar{
width:38px;
height:38px;
border-radius:50%;
background:#dbeafe;
display:flex;
align-items:center;
justify-content:center;
color:#2563eb;
font-weight:600;
font-size:14px;
flex-shrink:0;
}
 
.badge{
display:inline-block;
padding:4px 10px;
border-radius:20px;
font-size:12px;
font-weight:500;
background:#dbeafe;
color:#2563eb;
}
 
.actions{
display:flex;
gap:8px;
}
 
.btn-action{
border:none;
padding:8px 10px;
border-radius:8px;
cursor:pointer;
transition: opacity 0.2s;
}
 
.btn-action:hover{
opacity:0.8;
}
 
.edit{
background:#dbeafe;
color:#2563eb;
}
 
.delete{
background:#fee2e2;
color:#ef4444;
}
 
/* MODAL */
 
.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(15,23,42,.5);
justify-content:center;
align-items:center;
z-index:999;
}
 
.modal-content{
background:white;
padding:30px;
border-radius:16px;
width:500px;
max-height:90vh;
overflow:auto;
box-shadow:0 20px 60px rgba(0,0,0,0.2);
}
 
.modal-content h2{
margin-bottom:20px;
color:#1a1a2e;
font-size:18px;
font-weight:600;
}
 
.form-group{
margin-bottom:12px;
}
 
.form-group input,
.form-group select{
width:100%;
padding:11px 14px;
border:1px solid #e2e8f0;
border-radius:10px;
font-family:'Poppins', sans-serif;
font-size:14px;
outline:none;
transition: border 0.2s;
}
 
.form-group input:focus,
.form-group select:focus{
border-color:#2563eb;
}
 
.modal-buttons{
display:flex;
gap:10px;
margin-top:15px;
}
 
.btn-save{
background:#2563eb;
color:white;
border:none;
padding:12px;
border-radius:10px;
cursor:pointer;
flex:1;
font-family:'Poppins', sans-serif;
font-weight:500;
transition: background 0.2s;
}
 
.btn-save:hover{
background:#1d4ed8;
}
 
.btn-close{
background:#f1f5f9;
color:#475569;
border:none;
padding:12px;
border-radius:10px;
cursor:pointer;
flex:1;
font-family:'Poppins', sans-serif;
font-weight:500;
}
 
@media(max-width:900px){
 
.container{
flex-direction:column;
}
 
.sidebar{
width:100%;
}
 
table{
font-size:12px;
}
 
}
 
</style>
</head>
 
<body>
 
<div class="container">
 
<!-- SIDEBAR -->
 
<div class="sidebar">
 
<div class="logo">
<img src="{{ asset('assets/logo-pasoc.webp') }}" width="200">
</div>
 
<div class="menu">
    <a href="{{ url('/home_admin') }}"><i class="fa fa-house"></i> Home</a>
    <a href="{{ url('/home_admin') }}"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="{{ url('ver_ventas') }}"><i class="fa fa-chart-pie"></i> Ventas</a>
    <a href="#"><i class="fa fa-box"></i> Applications</a>
    <a href="#"><i class="fa fa-cubes"></i> Almacen</a>
    <a href="{{ url('/ver_clientes') }}" class="active"><i class="fa fa-users"></i> Clientes</a>
    <a href="{{ url('/ver_usuarios') }}"><i class="fa fa-users"></i> Usuarios</a>
    <a href="{{ url('/ver_leads') }}"><i class="fa fa-users"></i> Leads</a>
</div>
 
</div>
 
<!-- MAIN -->
 
<div class="main">
 
<div class="topbar">
 
<h2>Gestión de Clientes</h2>
 
<div class="right-top">
 
<input class="search" placeholder="Buscar cliente...">
 
<button class="btn-new" onclick="abrirModal()">
<i class="fa fa-plus"></i>
Nuevo Cliente
</button>
 
</div>
 
</div>
 
<div class="card">
 
<table>
 
<thead>
<tr>
<th>Cliente</th>
<th>Correo</th>
<th>Teléfono</th>
<th>DNI</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>
 
<tbody>
 
@foreach($clientes as $cliente)
 
<tr>
 
<td>
<div class="user">
<div class="avatar">{{ strtoupper(substr($cliente->nombre_completo, 0, 1)) }}</div>
{{ $cliente->nombre_completo }}
</div>
</td>
 
<td>{{ $cliente->correo }}</td>
<td>{{ $cliente->telefono }}</td>
<td>{{ $cliente->dni }}</td>
<td><span class="badge">{{ $cliente->estado }}</span></td>
 
<td>
 
<div class="actions">
 
<button class="btn-action edit"
onclick="editarCliente(
'{{ $cliente->id_cliente }}',
'{{ $cliente->tipo_persona }}',
'{{ $cliente->nombre_completo }}',
'{{ $cliente->correo }}',
'{{ $cliente->telefono }}',
'{{ $cliente->direccion }}',
'{{ $cliente->ubigeo }}',
'{{ $cliente->estado }}',
'{{ $cliente->ruc }}',
'{{ $cliente->nombre_comercial }}',
'{{ $cliente->representante_legal }}',
'{{ $cliente->dni }}'
)">
<i class="fa fa-pen"></i>
</button>
 
<a href="eliminar_cliente/{{ $cliente->id_cliente }}"
onclick="return confirm('¿Eliminar cliente?')">
 
<button class="btn-action delete">
<i class="fa fa-trash"></i>
</button>
 
</a>
 
</div>
 
</td>
 
</tr>
 
@endforeach
 
</tbody>
 
</table>
 
</div>
 
</div>
 
</div>
 
<!-- MODAL -->
 
<div class="modal" id="modalCliente">
 
<div class="modal-content">
 
<h2 id="tituloModal">Nuevo Cliente</h2>
 
<form method="POST" id="formCliente">
 
@csrf
 
<div class="form-group">
<select name="tipo_persona" id="tipo_persona">
<option value="Natural">Natural</option>
<option value="Juridica">Jurídica</option>
</select>
</div>
 
<div class="form-group">
<input type="text" name="nombre_completo" id="nombre_completo" placeholder="Nombre completo">
</div>
 
<div class="form-group">
<input type="email" name="correo" id="correo" placeholder="Correo">
</div>
 
<div class="form-group">
<input type="text" name="telefono" id="telefono" placeholder="Teléfono">
</div>
 
<div class="form-group">
<input type="text" name="direccion" id="direccion" placeholder="Dirección">
</div>
 
<div class="form-group">
<input type="text" name="ubigeo" id="ubigeo" placeholder="Ubigeo">
</div>
 
<div class="form-group">
<select name="estado" id="estado">
  <option value="sin pedidos">Sin pedido</option>
  <option value="pedido en espera">Pedido en espera</option>
</select>
</div>
 
<div class="form-group">
<input type="text" name="ruc" id="ruc" placeholder="RUC">
</div>
 
<div class="form-group">
<input type="text" name="nombre_comercial" id="nombre_comercial" placeholder="Nombre Comercial">
</div>
 
<div class="form-group">
<input type="text" name="representante_legal" id="representante_legal" placeholder="Representante Legal">
</div>
 
<div class="form-group">
<input type="text" name="dni" id="dni" placeholder="DNI">
</div>
 
<div class="modal-buttons">
<button class="btn-save">Guardar</button>
 
<button type="button"
class="btn-close"
onclick="cerrarModal()">
Cerrar
</button>
</div>
 
</form>
 
</div>
</div>
 
<script>
 
function abrirModal(){
document.getElementById('modalCliente').style.display='flex';
document.getElementById('formCliente').action='guardar_cliente';
document.getElementById('tituloModal').innerHTML='Nuevo Cliente';
document.getElementById('formCliente').reset();
}
 
function cerrarModal(){
document.getElementById('modalCliente').style.display='none';
}
 
function editarCliente(
id,tipo,nombre,correo,telefono,
direccion,ubigeo,estado,
ruc,comercial,representante,dni
){
abrirModal();
document.getElementById('tituloModal').innerHTML='Editar Cliente';
document.getElementById('formCliente').action='editar_cliente/'+id;
document.getElementById('tipo_persona').value=tipo;
document.getElementById('nombre_completo').value=nombre;
document.getElementById('correo').value=correo;
document.getElementById('telefono').value=telefono;
document.getElementById('direccion').value=direccion;
document.getElementById('ubigeo').value=ubigeo;
document.getElementById('estado').value=estado;
document.getElementById('ruc').value=ruc;
document.getElementById('nombre_comercial').value=comercial;
document.getElementById('representante_legal').value=representante;
document.getElementById('dni').value=dni;
}
 
</script>
 
</body>
</html>