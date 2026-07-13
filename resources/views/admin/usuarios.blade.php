@include('layouts.header')
<style>
.main{flex:1;padding:25px;background:#f4f6fa;min-height:100vh;}
.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
.topbar h2{color:#6c3ce9;}
.card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 3px 12px rgba(0,0,0,0.05);overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
th{text-align:left;padding:15px 10px;color:#888;font-size:14px;font-weight:500;}
td{padding:15px 10px;border-top:1px solid #eee;font-size:14px;color:#555;}
tr:hover{background:#fafafa;}
.user{display:flex;align-items:center;gap:10px;}
.avatar{width:40px;height:40px;border-radius:50%;background:#4b2ad6;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:16px;}
.tag-rol{display:inline-block;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;}
.tag-admin{background:#ede7ff;color:#4b2ad6;}
.tag-agente{background:#fff3e0;color:#e65100;}
.tag-cliente{background:#e8f5e9;color:#2e7d32;}
.btn-sm{background:transparent;border:1px solid #ddd;padding:5px 12px;border-radius:6px;cursor:pointer;font-size:12px;text-decoration:none;color:#555;transition:.2s;display:inline-flex;align-items:center;gap:5px;}
.btn-sm:hover{background:#4b2ad6;color:#fff;border-color:#4b2ad6;}
.btn-primary{background:#4b2ad6;color:#fff;border:none;padding:9px 20px;border-radius:8px;font-size:13px;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;gap:6px;}
.btn-primary:hover{background:#3a1fb0;}
.btn-secondary{background:transparent;color:#666;border:1px solid #ddd;padding:9px 18px;border-radius:8px;font-size:13px;cursor:pointer;transition:.2s;}
.btn-secondary:hover{background:#f5f5f5;}

.modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.4);z-index:1000;justify-content:center;align-items:center;}
.modal-overlay.active{display:flex;}
.modal{background:#fff;border-radius:15px;padding:30px;width:90%;max-width:400px;box-shadow:0 10px 40px rgba(0,0,0,.2);}
.modal h3{margin-bottom:20px;color:#4b2ad6;}
.modal .form-group{margin-bottom:15px;}
.modal .form-group label{display:block;font-weight:600;font-size:13px;color:#444;margin-bottom:5px;}
.modal .form-group input,.modal .form-group select{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:8px;font-size:14px;outline:none;}
.modal .form-group input:focus,.modal .form-group select:focus{border-color:#4b2ad6;}
.modal-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px;}
.msg-success{background:#d4edda;color:#155724;padding:12px 18px;border-radius:10px;margin-bottom:15px;display:flex;align-items:center;gap:8px;}
.msg-error{background:#f8d7da;color:#721c24;padding:12px 18px;border-radius:10px;margin-bottom:15px;display:flex;align-items:center;gap:8px;}
@media(max-width:900px){table{font-size:12px;}}
</style>

<div class="main">

<div class="topbar">
<h2><i class="fa fa-users"></i> Usuarios</h2>
</div>

@if(session('success'))
<div class="msg-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="msg-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="card">
<table>
<thead>
<tr>
<th>Usuario</th>
<th>Correo</th>
<th>Rol</th>
<th>Creado</th>
<th></th>
</tr>
</thead>
<tbody>
@foreach($usuarios as $usuario)
@php
$rolLabel = match($usuario->rol) { 1 => 'Admin', 2 => 'Agente', 3 => 'Cliente', default => 'Rol '.$usuario->rol };
$rolClass = match($usuario->rol) { 1 => 'tag-admin', 2 => 'tag-agente', 3 => 'tag-cliente', default => '' };
$initial = strtoupper(substr($usuario->username, 0, 1));
@endphp
<tr>
<td>
<div class="user">
<div class="avatar">{{ $initial }}</div>
{{ $usuario->username }}
</div>
</td>
<td>{{ $usuario->correo }}</td>
<td><span class="tag-rol {{ $rolClass }}">{{ $rolLabel }}</span></td>
<td>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}</td>
<td>
<button class="btn-sm" onclick="abrirModal({{ $usuario->id_usuario }}, '{{ $usuario->username }}', '{{ $usuario->correo }}', {{ $usuario->rol }})"><i class="fa fa-pencil"></i></button>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>

<div class="modal-overlay" id="modalEditar">
<div class="modal">
<h3><i class="fa fa-pencil"></i> Editar Usuario</h3>
<form method="POST" id="formEditar">
@csrf @method('PUT')
<div class="form-group">
<label>Username</label>
<input type="text" name="username" id="editUsername" required>
</div>
<div class="form-group">
<label>Correo</label>
<input type="email" name="correo" id="editCorreo" required>
</div>
<div class="form-group">
<label>Rol</label>
<select name="rol" id="editRol">
<option value="1">Admin</option>
<option value="2">Agente</option>
<option value="3">Cliente</option>
</select>
</div>
<div class="modal-actions">
<button type="button" class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
<button class="btn-primary"><i class="fa fa-save"></i> Guardar</button>
</div>
</form>
</div>
</div>

<script>
function abrirModal(id, username, correo, rol) {
document.getElementById('formEditar').action = '/usuarios/' + id;
document.getElementById('editUsername').value = username;
document.getElementById('editCorreo').value = correo;
document.getElementById('editRol').value = rol;
document.getElementById('modalEditar').classList.add('active');
}
function cerrarModal() {
document.getElementById('modalEditar').classList.remove('active');
}
document.getElementById('modalEditar').addEventListener('click', function(e) {
if (e.target === this) cerrarModal();
});
</script>

</body>
</html>
