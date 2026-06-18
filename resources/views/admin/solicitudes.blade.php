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
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.topbar h1{
    color:#4b2ad6;
    font-size:26px;
}

.search-box{
    position:relative;
}

.search-box input{
    padding:10px 40px 10px 15px;
    border:1px solid #ddd;
    border-radius:20px;
    width:250px;
    background:#fff;
}

.search-box i{
    position:absolute;
    right:15px;
    top:10px;
    color:#888;
}

.panel{
    background:#fff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 3px 12px rgba(0,0,0,.05);
    overflow-x:auto;
}

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

.sub{
    font-size:12px;
    color:#888;
}

.status{
    display:flex;
    align-items:center;
    gap:8px;
}

.dot{
    width:10px;
    height:10px;
    border-radius:50%;
}

</style>
<style>

.btn-view{
    background:#3498db;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
}

.btn-edit{
    background:#6c3ce9;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
}

.btn-view:hover,
.btn-edit:hover{
    opacity:.9;
}

.actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.ticket-link{
    color:#4b2ad6;
    font-weight:bold;
    text-decoration:none;
}

.ticket-link:hover{
    text-decoration:underline;
}

.abierto{
    background:#f39c12;
}

.proceso{
    background:#3498db;
}

.cerrado{
    background:#2ecc71;
}

.rechazado{
    background:#e74c3c;
}
.container-tables{
    display:flex;
    gap:20px;
    align-items:flex-start;
}

.panel-left{
    width:65%;
}

.panel-right{
    width:35%;
}

@media(max-width:1200px){
    .container-tables{
        flex-direction:column;
    }

    .panel-left,
    .panel-right{
        width:100%;
    }
}
.modal-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.5);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box{
    width:500px;
    max-width:95%;
    background:white;
    border-radius:15px;
    padding:25px;
}

.modal-box h3{
    margin-bottom:20px;
    color:#4b2ad6;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.form-group select,
.form-group textarea{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.btn-cancelar{
    background:#95a5a6;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
}

.btn-guardar{
    background:#6c3ce9;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
}
</style>

<div class="main">

    <div class="topbar">

        <h1>Gestión de Solicitudes</h1>

        <div class="search-box">
            <input type="text" placeholder="Buscar solicitud...">
            <i class="fa fa-search"></i>
        </div>

    </div>

    <div class="container-tables">

    <!-- SOLICITUDES -->
    <div class="panel panel-left">

        <table>

            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th>Ticket</th>
                    <th>Envío</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            @forelse($solicitudes as $solicitud)

                @php

                    $estadoClass = 'abierto';

                    if(strtolower($solicitud->estado) == 'en proceso'){
                        $estadoClass = 'proceso';
                    }

                    if(strtolower($solicitud->estado) == 'cerrado'){
                        $estadoClass = 'cerrado';
                    }

                    if(strtolower($solicitud->estado) == 'rechazado'){
                        $estadoClass = 'rechazado';
                    }

                @endphp

                <tr>

                    <td>

                        <div class="user">

                            <div class="avatar"></div>

                            <div>

                                {{ $solicitud->cliente->nombre_completo ?? '-' }}

                                <br>

                                <span class="sub">

                                    {{ $solicitud->cliente->correo ?? '-' }}

                                </span>

                            </div>

                        </div>

                    </td>

                    <td>

                        {{ strtoupper($solicitud->tipo) }}

                    </td>

                    <td>

                        {{ Str::limit($solicitud->motivo,40) }}

                    </td>

                    <td>

                        <a
                            href="{{ route('solicitudes.ver',$solicitud->id_solicitud) }}"
                            class="ticket-link">

                            #SOL-{{ $solicitud->id_solicitud }}

                        </a>

                    </td>

                    <td>

                        #{{ $solicitud->id_envio }}

                    </td>

                    <td>

                        <div class="status">

                            <div class="dot {{ $estadoClass }}"></div>

                            {{ $solicitud->estado }}

                        </div>

                    </td>

                    <td>

                        @if($solicitud->created_at)

                            {{
                                \Carbon\Carbon::parse(
                                    $solicitud->created_at
                                )->format('d/m/Y')
                            }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        <div class="actions">

                            <a href="{{ route('solicitudes.ver',$solicitud->id_solicitud) }}"
                               class="btn-view">
                                Ver Solicitud
                            </a>

                            <a href="#"
                               class="btn-edit btnEstado"
                               data-id="{{ $solicitud->id_solicitud }}"
                               data-estado="{{ $solicitud->estado }}">
                                Cambiar Estado
                            </a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" style="text-align:center;padding:30px;">

                        No existen solicitudes registradas

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
     <!-- CAMBIO PASSWORD -->
    <div class="panel panel-right">

        <h3 style="margin-bottom:15px">
            Solicitudes de Contraseña
        </h3>

        <table>

            <thead>
                <tr>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

            @forelse($passwords as $pass)

                <tr>

                    <td>
                        {{ $pass->usuario->correo}}
                    </td>

                    <td>

                        @if($pass->estado=='Pendiente')

                            <span style="color:#f39c12">
                                Pendiente
                            </span>

                        @elseif($pass->estado=='Aprobado')

                            <span style="color:#27ae60">
                                Aceptado
                            </span>

                        @else

                            <span style="color:#e74c3c">
                                Rechazado
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($pass->estado=='Pendiente')

                            <a href="{{ route('password.aprobar',$pass->id_solicitud_cambio_password) }}"
                               class="btn-view">
                               Aprobar
                            </a>

                            <a href="{{ route('password.rechazar',$pass->id_solicitud_cambio_password) }}"
                               class="btn-edit">
                               Rechazar
                            </a>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="3">
                        No hay solicitudes
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
</div>
<div class="modal-overlay" id="modalEstado">

    <div class="modal-box">

        <h3>Cambiar Estado</h3>

        <input type="hidden" id="idSolicitud">

        <div class="form-group">

            <label>Estado</label>

            <select id="estadoSolicitud">

                <option value="PENDIENTE">PENDIENTE</option>
                <option value="EN_REVISION">EN REVISION</option>
                <option value="APROBADO">APROBADO</option>
                <option value="RECHAZADO">RECHAZADO</option>
                <option value="ATENDIDO">ATENDIDO</option>
                <option value="CERRADO">CERRADO</option>


            </select>

        </div>

        <div class="form-group">

            <label>Respuesta</label>

            <textarea id="respuestaSolicitud"
                rows="4"></textarea>

        </div>

        <div class="modal-actions">

            <button id="cerrarModal"
                    class="btn-cancelar">
                Cancelar
            </button>

            <button id="guardarEstado"
                    class="btn-guardar">
                Guardar
            </button>

        </div>

    </div>

</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$(document).ready(function(){

    $('.btnEstado').click(function(e){

        e.preventDefault();

        $('#idSolicitud').val(
            $(this).data('id')
        );

        $('#estadoSolicitud').val(
            $(this).data('estado')
        );

        $('#modalEstado').css(
            'display',
            'flex'
        );

    });

    $('#cerrarModal').click(function(){

        $('#modalEstado').hide();

    });

    $('#guardarEstado').click(function(){

        $.ajax({

            url: "{{ route('solicitudes.ajax.estado') }}",

            type:'POST',

            data:{
                _token:'{{ csrf_token() }}',
                id_solicitud:$('#idSolicitud').val(),
                estado:$('#estadoSolicitud').val(),
                respuesta:$('#respuestaSolicitud').val()
            },

            success:function(response){

                alert(response.mensaje);

                location.reload();

            },

            error:function(){

                alert('Error al actualizar');

            }

        });

    });

});

</script>
</html>
