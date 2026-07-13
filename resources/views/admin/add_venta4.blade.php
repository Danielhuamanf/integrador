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
}

.topbar h1{
    color:#4b2ad6;
}

.steps{
    display:flex;
    justify-content:space-between;
    background:#fff;
    padding:20px;
    border-radius:15px;
    margin-bottom:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.step{
    flex:1;
    text-align:center;
}

.step-circle{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#ddd;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    margin-bottom:10px;
}

.step.active .step-circle{
    background:#6c3ce9;
}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
    font-weight:bold;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#fafafa;
}

.btn{
    background:#6c3ce9;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
}

.table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.table th,
.table td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:left;
}

.total-box{
    background:#faf7ff;
    padding:15px;
    border-radius:10px;
    margin-top:20px;
}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

}

</style>

<div class="main">

    <div class="topbar">

        <h1>DAM / Aduanas</h1>

    </div>

    {{-- PASOS --}}
    <div class="steps">

        <div class="step active">
            <div class="step-circle">1</div>
            Registro
        </div>

        <div class="step active">
            <div class="step-circle">2</div>
            Costos
        </div>

        <div class="step active">
            <div class="step-circle">3</div>
            Tracking
        </div>

        <div class="step active">
            <div class="step-circle">4</div>
            DAM
        </div>

        <div class="step">
            <div class="step-circle">5</div>
            Confirmación
        </div>

    </div>

    <div class="grid">

        {{-- FORM DAM --}}
        <div class="card">

            <h3>Información DAM</h3>

            <form method="POST"
            action="{{ route('ventas.guardar.dam', $envio->id_envio) }}">

                @csrf

                <div class="form-group">

                    <label>Número DAM</label>

                    <input type="text"
                    name="numero_dam"
                    value="{{ $dam->numero_dam }}">

                </div>

                <div class="form-group">

                    <label>Canal Control</label>

                    <select name="canal_control">

                        <option value="Verde">
                            Verde
                        </option>

                        <option value="Naranja">
                            Naranja
                        </option>

                        <option value="Rojo">
                            Rojo
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Fecha Numeración</label>

                    <input type="date"
                    name="fecha_numeracion"
                    value="{{ $dam->fecha_numeracion }}">

                </div>

                <div class="form-group">

                    <label>Aduana</label>

                    <input type="text"
                    name="aduana"
                    value="{{ $dam->aduana }}">

                </div>

                <div class="form-group">

                    <label>Estado</label>

                    <input type="text"
                    name="estado"
                    value="{{ $dam->estado }}">

                </div>

                <button class="btn">

                    Guardar DAM

                </button>

            </form>
            <br>
            <button class="btn" onclick="location.href = ' {{ route('ventas.confirmacion', $envio->id_envio) }}';" >Siguiente</button>
           
        </div>

        {{-- COSTOS --}}
        <div class="card">

            <h3>Costos Aduaneros</h3>

            <form method="POST"
            action="{{ route('ventas.guardar.costo.dam', $envio->id_envio) }}">

                @csrf

                <div class="form-group">

                    <label>Tipo Costo</label>

                    <input type="text"
                    name="tipo_costo">

                </div>

                <div class="form-group">

                    <label>Monto</label>

                    <input type="number"
                    step="0.01"
                    name="monto">

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

                    <label>Descripción</label>

                    <textarea
                    name="descripcion"></textarea>

                </div>

                <button class="btn">

                    Agregar Costo

                </button>

            </form>

            <table class="table">

                <thead>

                    <tr>

                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Moneda</th>

                    </tr>

                </thead>

                <tbody>

                    @php
                        $total = 0;
                    @endphp

                    @foreach($costos as $costo)

                        @php
                            $total += $costo->monto;
                        @endphp

                        <tr>

                            <td>
                                {{ $costo->tipo_costo }}
                            </td>

                            <td>
                                {{ $costo->monto }}
                            </td>

                            <td>
                                {{ $costo->moneda }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="total-box">

                <strong>

                    Total Aduanero:
                    {{ number_format($total,2) }}

                </strong>

            </div>

        </div>

    </div>

</div>

</body>
</html>