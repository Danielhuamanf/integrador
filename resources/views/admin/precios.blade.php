{{-- resources/views/admin/precios/index.blade.php --}}

@include('layouts.header')

<style>

.main{
    flex:1;
    padding:25px;
    background:#f4f6fa;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.topbar h1{
    color:#6c3ce9;
}

.btn{
    background:#6c3ce9;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
}

.card{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 3px 10px rgba(0,0,0,.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    padding:14px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.badge{
    padding:5px 10px;
    border-radius:20px;
    background:#ede7ff;
    color:#6c3ce9;
    font-size:12px;
}

.action-btn{
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
    margin-right:5px;
}

.edit{
    background:#6c3ce9;
    color:#fff;
}

.delete{
    background:#ffebeb;
    color:#d63031;
}

.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.5);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
}

.modal-content{
    background:#fff;
    width:900px;
    max-width:95%;
    border-radius:15px;
    padding:25px;
    max-height:90vh;
    overflow:auto;
}

.row{
    display:flex;
    gap:15px;
}

.form-group{
    flex:1;
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    font-size:13px;
}

.form-group input,
.form-group select{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
    background:#fafafa;
}

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

.btn-cancel{
    background:#eee;
    color:#333;
}

.pagination{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
    margin-top:30px;
    flex-wrap:wrap;
}

.pagination .page-item{
    list-style:none;
}

.pagination .page-link{
    border:none;
    background:#fff;
    color:#555;
    padding:10px 16px;
    border-radius:10px;
    text-decoration:none;
    box-shadow:0 2px 8px rgba(0,0,0,.05);
    transition:.2s;
    font-size:14px;
    font-weight:600;
}

.pagination .page-link:hover{
    background:#6c3ce9;
    color:#fff;
    transform:translateY(-2px);
}

.pagination .active .page-link{
    background:#6c3ce9;
    color:#fff;
}

.pagination .disabled .page-link{
    background:#f1f1f1;
    color:#aaa;
    cursor:not-allowed;
    box-shadow:none;
}
</style>

<div class="main">

    <div class="topbar">

        <h1>Gestión de Tarifas</h1>

        <button class="btn"
        onclick="openCreateModal()">
            Nueva Tarifa
        </button>

    </div>

    <div class="card">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Origen</th>

                    <th>Destino</th>

                    <th>Tipo</th>

                    <th>Peso</th>

                    <th>Dimensiones</th>

                    <th>Monto</th>

                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>
              
                @foreach($precios as $precio)

                    <tr>

                        <td>
                            {{  $precio->id_precio }}
                        </td>

                        <td>
                            {{ $precio->zonaOrigen->nombre_zona ?? '-' }}
                        </td>

                        <td>
                            {{ $precio->zonaDestino->nombre_zona ?? '-' }}
                        </td>

                        <td>

                            <span class="badge">
                                {{ $precio->tipo_envio }}
                            </span>

                        </td>

                        <td>
                            {{ $precio->peso_base }}
                            -
                            {{ $precio->peso_tope }}
                            KG
                        </td>

                        <td>

                           <div>
                              Alto:
                              {{ $precio->alto_base }}
                              -
                              {{ $precio->alto_tope }}
                          </div>

                          <div>
                              Ancho:
                              {{ $precio->ancho_base }}
                              -
                              {{ $precio->ancho_tope }}
                          </div>

                          <div>
                              Largo:
                              {{ $precio->largo_base }}
                              -
                              {{ $precio->largo_tope }}
                          </div>

                        </td>

                        <td>
                            {{ $precio->moneda }}
                            {{ number_format($precio->monto,2) }}
                        </td>

                        <td>

                            <button
                            class="action-btn edit"
                            onclick="editPrecio({{ $precio }})">
                                Editar
                            </button>

                            <form
                            action="{{ route('precios.destroy',$precio->id_precio) }}"
                            method="POST"
                            style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button
                                class="action-btn delete"
                                onclick="return confirm('Eliminar tarifa?')">
                                    Eliminar
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>
        <div class="pagination-wrapper">
            {{ $precios->links() }}
        </div>

    </div>

</div>

{{-- MODAL --}}

<div class="modal" id="modalPrecio">

    <div class="modal-content">

        <h2 id="modalTitle">
            Nueva Tarifa
        </h2>

        <form
        method="POST"
        id="precioForm">

            @csrf

            <div id="methodField"></div>

            <div class="row">

                <div class="form-group">

                    <label>Zona Origen</label>

                    <select name="id_zona_origen">

                        @foreach($zonas as $zona)

                            <option value="{{ $zona->id_zona }}">
                                {{ $zona->nombre_zona }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Zona Destino</label>

                    <select name="id_zona_dest">

                        @foreach($zonas as $zona)

                            <option value="{{ $zona->id_zona }}">
                                {{ $zona->nombre_zona }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="form-group">
                    <label>Peso Base</label>
                    <input type="number" step="0.01" name="peso_base">
                </div>

                <div class="form-group">
                    <label>Peso Tope</label>
                    <input type="number" step="0.01" name="peso_tope">
                </div>

            </div>

            <div class="row">

                <div class="form-group">
                    <label>Alto Base</label>
                    <input type="number" step="0.01" name="alto_base">
                </div>

                <div class="form-group">
                    <label>Alto Tope</label>
                    <input type="number" step="0.01" name="alto_tope">
                </div>

            </div>

            <div class="row">

                <div class="form-group">
                    <label>Ancho Base</label>
                    <input type="number" step="0.01" name="ancho_base">
                </div>

                <div class="form-group">
                    <label>Ancho Tope</label>
                    <input type="number" step="0.01" name="ancho_tope">
                </div>

            </div>

            <div class="row">

                <div class="form-group">
                    <label>Largo Base</label>
                    <input type="number" step="0.01" name="largo_base">
                </div>

                <div class="form-group">
                    <label>Largo Tope</label>
                    <input type="number" step="0.01" name="largo_tope">
                </div>

            </div>

            <div class="row">

                <div class="form-group">

                    <label>Tipo Envío</label>

                    <select name="tipo_envio">

                        @foreach($tipos as $tipo)

                            <option value="{{ $tipo->id_tipo }}">
                                {{ $tipo->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Moneda</label>

                    <select name="moneda">

                        <option value="PEN">
                            PEN
                        </option>

                        <option value="USD">
                            USD
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Monto</label>

                    <input type="number"
                    step="0.01"
                    name="monto">

                </div>

            </div>

            <div class="modal-actions">

                <button type="button"
                class="btn btn-cancel"
                onclick="closeModal()">
                    Cancelar
                </button>

                <button type="submit"
                class="btn">
                    Guardar
                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openCreateModal(){

    document.getElementById('modalPrecio').style.display = 'flex';

    document.getElementById('modalTitle').innerText =
        'Nueva Tarifa';

    document.getElementById('precioForm').action =
        "{{ route('precios.store') }}";

    document.getElementById('methodField').innerHTML = '';

    document.getElementById('precioForm').reset();

}

function closeModal(){

    document.getElementById('modalPrecio').style.display = 'none';

}

function editPrecio(precio){

    openCreateModal();

    document.getElementById('modalTitle').innerText =
        'Editar Tarifa';

    document.getElementById('precioForm').action =
        'precios/update/' + precio.id_precio;

    document.getElementById('methodField').innerHTML =
        '@method("PUT")';

    Object.keys(precio).forEach(key => {

        let input =
            document.querySelector(`[name="${key}"]`);

        if(input){

            input.value = precio[key];

        }

    });

}

window.onclick = function(event){

    let modal =
        document.getElementById('modalPrecio');

    if(event.target == modal){

        closeModal();

    }

}

</script>

</body>
</html>