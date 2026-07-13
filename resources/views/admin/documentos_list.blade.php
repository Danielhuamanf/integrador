@include('layouts.header')

<style>
.main{flex:1;padding:25px;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.topbar h2{color:#6c3ce9;}
.right-top{display:flex;gap:10px;flex-wrap:wrap;}
.search{padding:10px 15px;border-radius:20px;border:1px solid #ddd;width:250px;outline:none;}
.btn-new,.btn-save{background:#6c3ce9;color:#fff;border:none;padding:10px 18px;border-radius:10px;cursor:pointer;}
.card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 3px 12px rgba(0,0,0,.05);overflow:auto;}
table{width:100%;border-collapse:collapse;}
th,td{padding:15px 10px;text-align:left;}
th{background:#fafafa;color:#888;}
td{border-top:1px solid #eee;color:#555;}
tr:hover{background:#fafafa;}
.user{display:flex;align-items:center;gap:10px;}
.avatar{width:40px;height:40px;border-radius:50%;background:#6c3ce9;color:#fff;display:flex;align-items:center;justify-content:center;}
.actions{display:flex;gap:8px;}
.btn-action{border:none;padding:10px;border-radius:8px;cursor:pointer;text-decoration:none;}
.edit{background:#ede7ff;color:#6c3ce9}.delete{background:#ffe7e7;color:red}.view{background:#e7f1ff;color:#007bff}.download{background:#e8fff0;color:#008a3d}
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.4);justify-content:center;align-items:center;z-index:999;}
.modal-content{background:#fff;padding:25px;border-radius:14px;width:520px;max-height:90vh;overflow:auto;}
.form-group{margin-bottom:12px;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;}
.modal-buttons{display:flex;gap:10px;}
.btn-close{background:#ddd;border:none;padding:12px;border-radius:10px;cursor:pointer;flex:1;}
.estado{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;}
.activo{background:#d4edda;color:#155724;}
</style>

<div class="main">
    <div class="topbar">
        <h2>Documentos</h2>
        <div class="right-top">
            <input type="text" class="search" id="buscar" placeholder="Buscar documento...">
            <button class="btn-new" onclick="abrirModal()"><i class="fa fa-plus"></i> Nuevo Documento</button>
        </div>
    </div>

    <div class="card">
        <table id="tablaDocumentos">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Envío</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentos as $documento)
                <tr>
                    <td>
                        <div class="user">
                            <div class="avatar"><i class="fa fa-file"></i></div>
                            {{ $documento->nombre_doc }}
                        </div>
                    </td>
                    <td>{{ $documento->envio->id_envio ?? '-' }}</td>
                    <td>{{ $documento->descripcion_doc }}</td>
                    <td>{{ $documento->created_at }}</td>
                    <td><span class="estado activo">Cargado</span></td>
                    <td>
                        <div class="actions">
                            <button class="btn-action edit" onclick="editarDocumento('{{ $documento->id_documento }}','{{ addslashes($documento->id_envio) }}','{{ addslashes($documento->nombre_doc) }}','{{ addslashes($documento->descripcion_doc) }}')"><i class="fa fa-pen"></i></button>

                            <form method="POST" action="{{ route('documentos.destroy',$documento->id_documento) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action delete" onclick="return confirm('¿Eliminar documento?')"><i class="fa fa-trash"></i></button>
                            </form>

                            <a class="btn-action view" href="{{ route('documentos.ver',$documento->id_documento) }}" target="_blank"><i class="fa fa-eye"></i></a>
                            <a class="btn-action download" href="{{ route('documentos.download',$documento->id_documento) }}"><i class="fa fa-download"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="modalDocumento">
    <div class="modal-content">
        <h2 id="tituloModal">Nuevo Documento</h2>
        <form method="POST" id="formDocumento" enctype="multipart/form-data">
            @csrf
            <div id="methodSpoof"></div>

            <div class="form-group">
                <select name="id_envio" id="id_envio" required>
                    <option value="">Seleccionar envío</option>
                    @foreach($envios as $envio)
                    <option value="{{ $envio->id_envio }}">{{ $envio->id_envio }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="nombre_doc" id="nombre_doc" placeholder="Nombre documento" required>
            </div>

            <div class="form-group">
                <textarea name="descripcion_doc" id="descripcion_doc" placeholder="Descripción"></textarea>
            </div>

            <div class="form-group">
                <input type="file" name="archivo" id="archivo">
            </div>

            <div class="modal-buttons">
                <button class="btn-save">Guardar</button>
                <button type="button" class="btn-close" onclick="cerrarModal()">Cerrar</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(){
    document.getElementById('modalDocumento').style.display='flex';
    document.getElementById('tituloModal').innerHTML='Nuevo Documento';
    document.getElementById('formDocumento').action='{{ route("documentos.store") }}';
    document.getElementById('formDocumento').reset();
    document.getElementById('methodSpoof').innerHTML='';
    document.getElementById('archivo').required = true;
}
function cerrarModal(){ document.getElementById('modalDocumento').style.display='none'; }

function editarDocumento(id,id_envio,nombre,descripcion){
    abrirModal();
    document.getElementById('tituloModal').innerHTML='Editar Documento';
    document.getElementById('formDocumento').action='{{ url("documentos/update") }}/'+id;
    document.getElementById('methodSpoof').innerHTML='@method("PUT")';
    document.getElementById('id_envio').value=id_envio;
    document.getElementById('nombre_doc').value=nombre;
    document.getElementById('descripcion_doc').value=descripcion;
    document.getElementById('archivo').required = false;
}

document.getElementById('buscar').addEventListener('keyup',function(){
    let filtro=this.value.toLowerCase();
    document.querySelectorAll('#tablaDocumentos tbody tr').forEach(fila=>{
        fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? '' : 'none';
    });
});

window.onclick=function(e){
    if(e.target==document.getElementById('modalDocumento')) cerrarModal();
}
</script>

</body>
</html>
