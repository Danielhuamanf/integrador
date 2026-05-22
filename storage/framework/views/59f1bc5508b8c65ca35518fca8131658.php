<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
}

.topbar h2{
color:#6c3ce9;
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
}

.btn-new{
background:#6c3ce9;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
font-size:14px;
}

/* CARD */

.card{
background:#fff;
border-radius:12px;
padding:20px;
box-shadow:0 3px 12px rgba(0,0,0,0.05);
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
}

th{
text-align:left;
padding:15px 10px;
color:#888;
font-size:14px;
font-weight:500;
}

td{
padding:15px 10px;
border-top:1px solid #eee;
font-size:14px;
color:#555;
}

tr:hover{
background:#fafafa;
}

.user{
display:flex;
align-items:center;
gap:10px;
}

.avatar{
width:40px;
height:40px;
border-radius:50%;
background:#ddd;
}

.actions{
display:flex;
gap:8px;
}

.btn-action{
border:none;
padding:10px;
border-radius:8px;
cursor:pointer;
}

.edit{
background:#ede7ff;
color:#6c3ce9;
}

.delete{
background:#ffe7e7;
color:red;
}

/* MODAL */

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.4);
justify-content:center;
align-items:center;
z-index:999;
}

.modal-content{
background:white;
padding:25px;
border-radius:14px;
width:500px;
max-height:90vh;
overflow:auto;
}

.modal-content h2{
margin-bottom:20px;
color:#6c3ce9;
}

.form-group{
margin-bottom:12px;
}

.form-group input,
.form-group select{
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:10px;
}

.modal-buttons{
display:flex;
gap:10px;
margin-top:15px;
}

.btn-save{
background:#6c3ce9;
color:white;
border:none;
padding:12px;
border-radius:10px;
cursor:pointer;
flex:1;
}

.btn-close{
background:#ddd;
border:none;
padding:12px;
border-radius:10px;
cursor:pointer;
flex:1;
}

@media(max-width:900px){

table{
font-size:12px;
}

}

</style>


<!-- MAIN -->

<div class="main">

<div class="topbar">

<h2>Clientes</h2>

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
<th>Telefono</th>
<th>DNI</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td>
<div class="user">
<div class="avatar"></div>
<?php echo e($cliente->nombre_completo); ?>

</div>
</td>

<td><?php echo e($cliente->correo); ?></td>
<td><?php echo e($cliente->telefono); ?></td>
<td><?php echo e($cliente->dni); ?></td>
<td><?php echo e($cliente->estado); ?></td>

<td>

<div class="actions">

<button class="btn-action edit"
onclick="editarCliente(
'<?php echo e($cliente->id_cliente); ?>',
'<?php echo e($cliente->tipo_persona); ?>',
'<?php echo e($cliente->nombre_completo); ?>',
'<?php echo e($cliente->correo); ?>',
'<?php echo e($cliente->telefono); ?>',
'<?php echo e($cliente->direccion); ?>',
'<?php echo e($cliente->ubigeo); ?>',
'<?php echo e($cliente->estado); ?>',
'<?php echo e($cliente->ruc); ?>',
'<?php echo e($cliente->nombre_comercial); ?>',
'<?php echo e($cliente->representante_legal); ?>',
'<?php echo e($cliente->dni); ?>'
)">
<i class="fa fa-pen"></i>
</button>

<a href="eliminar_cliente/<?php echo e($cliente->id_cliente); ?>"
onclick="return confirm('¿Eliminar cliente?')">

<button class="btn-action delete">
<i class="fa fa-trash"></i>
</button>

</a>

</div>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

<?php echo csrf_field(); ?>

<div class="form-group">
<select name="tipo_persona" id="tipo_persona">
<option value="Natural">Natural</option>
<option value="Juridica">Juridica</option>
</select>
</div>

<div class="form-group">
<input type="text" name="nombre_completo" id="nombre_completo" placeholder="Nombre completo">
</div>

<div class="form-group">
<input type="email" name="correo" id="correo" placeholder="Correo">
</div>

<div class="form-group">
<input type="text" name="telefono" id="telefono" placeholder="Telefono">
</div>

<div class="form-group">
<input type="text" name="direccion" id="direccion" placeholder="Direccion">
</div>

<div class="form-group">
<input type="text" name="ubigeo" id="ubigeo" placeholder="Ubigeo">
</div>

<div class="form-group">
<select name="estado" id="tipo_persona">
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

document.getElementById('tituloModal')
.innerHTML='Editar Cliente';

document.getElementById('formCliente')
.action='editar_cliente/'+id;

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
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/clientes.blade.php ENDPATH**/ ?>