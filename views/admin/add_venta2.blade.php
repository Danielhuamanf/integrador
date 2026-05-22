{{-- resources/views/ventas/costos.blade.php --}}
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
    font-size:28px;
}

.steps{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:30px;
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.step{
    flex:1;
    position:relative;
    text-align:center;
}

.step:not(:last-child)::after{
    content:'';
    position:absolute;
    top:20px;
    right:-50%;
    width:100%;
    height:3px;
    background:#ddd;
}

.step.active:not(:last-child)::after{
    background:#6c3ce9;
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
    margin:0 auto 10px;
    font-weight:bold;
    position:relative;
    z-index:1;
}

.step.active .step-circle{
    background:#6c3ce9;
}

.step-title{
    font-size:13px;
    font-weight:bold;
    color:#555;
}

.step.active .step-title{
    color:#6c3ce9;
}

.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    margin-bottom:20px;
}

.card h3{
    margin-bottom:20px;
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
    font-size:13px;
    font-weight:bold;
    color:#555;
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
    color:white;
    padding:12px 18px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
}

.btn-cancel{
    background:#eee;
    color:#333;
}

.summary{
    margin-bottom:15px;
}

.summary span{
    display:block;
    font-size:13px;
    color:#888;
}

.summary strong{
    font-size:18px;
}

.total-box{
    background:#f3efff;
    padding:20px;
    border-radius:12px;
    text-align:center;
}

.total-box h2{
    color:#6c3ce9;
    font-size:35px;
    margin-top:10px;
}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

    .row{
        flex-direction:column;
    }

}

</style>

<div class="main">

    {{-- TOPBAR --}}
    <div class="topbar">

        <h1>Costos del Envío</h1>

        <div>

            <a href="{{ route('ventas.index') }}"
            class="btn btn-cancel">
                Cancelar
            </a>

        </div>

    </div>

    {{-- PASOS --}}
    <div class="steps">

        <div class="step active">
            <div class="step-circle">1</div>
            <div class="step-title">Registro</div>
        </div>

        <div class="step active">
            <div class="step-circle">2</div>
            <div class="step-title">Costos</div>
        </div>

        <div class="step">
            <div class="step-circle">3</div>
            <div class="step-title">Tracking</div>
        </div>

        <div class="step">
            <div class="step-circle">4</div>
            <div class="step-title">DAM</div>
        </div>

        <div class="step">
            <div class="step-circle">5</div>
            <div class="step-title">Confirmación</div>
        </div>

    </div>

    <form action="{{ route('ventas.guardar.costos', $envio->id_envio) }}"
    method="POST">

        @csrf

        <div class="grid">

            {{-- LEFT --}}
            <div>

                {{-- RESUMEN ENVIO --}}
                <div class="card">

                    <h3>Resumen del Envío</h3>

                    <div class="row">

                        <div class="form-group">

                            <label>Cliente</label>

                            <input type="text"
                            value="{{ $envio->cliente->nombre_completo ?? '' }}"
                            readonly>

                        </div>

                        <div class="form-group">

                            <label>Peso</label>

                            <input type="text"
                            value="{{ $envio->peso }} KG"
                            readonly>

                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group">

                            <label>Volumen</label>

                            <input type="text"
                            value="{{ $envio->volumen }}"
                            readonly>

                        </div>

                        <div class="form-group">

                            <label>Valor Declarado</label>

                            <input type="text"
                            value="{{ $envio->valor_declarado }}"
                            readonly>

                        </div>

                    </div>

                </div>

                {{-- COSTOS --}}
                <div class="card">

                    <h3>Tarifa Encontrada</h3>

                    <div class="row">

                        <div class="form-group">

                            <label>Tipo Costo</label>

                            <input type="text"
                            name="tipo_costo"
                            value="Flete">

                        </div>

                        <div class="form-group">

                            <label>Moneda</label>

                            <select name="moneda">

                                <option value="USD">
                                    USD
                                </option>

                                <option value="PEN">
                                    PEN
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Descripción</label>

                        <textarea
                        name="descripcion">Costo automático calculado según tarifa</textarea>

                    </div>

                    <div class="form-group">

                        <label>Monto</label>

                        <input type="number"
                        step="0.01"
                        id="monto"
                        name="monto"
                        value="{{ $precio->monto ?? 0 }}">

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div>

                <div class="card">

                    <h3>Resumen Financiero</h3>

                    <div class="summary">
                        <span>Tarifa Base</span>
                        <strong>
                            {{ $precio->monto ?? 0 }}
                        </strong>
                    </div>

                    <div class="summary">
                        <span>Moneda</span>
                        <strong>
                            {{ $precio->moneda ?? 'USD' }}
                        </strong>
                    </div>

                    <div class="total-box">

                        <span>Total</span>

                        <h2 id="totalPreview">
                            {{ $precio->monto ?? 0 }}
                        </h2>

                    </div>

                    <br>

                    <button type="submit"
                    class="btn"
                    style="width:100%;">

                        Guardar y Continuar

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

<script>

document.getElementById('monto')
.addEventListener('input', function(){

    document.getElementById('totalPreview')
        .innerText = this.value;

});

</script>

</body>
</html>