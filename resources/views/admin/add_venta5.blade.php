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
    background:#6c3ce9;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    margin-bottom:10px;
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

.card h3{
    margin-bottom:20px;
    color:#333;
}

.info{
    margin-bottom:12px;
}

.info span{
    display:block;
    color:#888;
    font-size:13px;
}

.info strong{
    color:#333;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th,
.table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

.badge{
    background:#6c3ce9;
    color:#fff;
    padding:6px 10px;
    border-radius:20px;
    font-size:12px;
}

.actions{
    display:flex;
    gap:15px;
    margin-top:25px;
}

.btn{
    background:#6c3ce9;
    color:#fff;
    padding:12px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
}

.btn-secondary{
    background:#eee;
    color:#333;
}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

}

</style>

<div class="main">

    <div class="topbar">

        <h1>Confirmación Final</h1>

        <div class="actions">

            <a href="{{ route('ventas.index') }}"
            class="btn btn-secondary">

                Finalizar

            </a>

            <button onclick="window.print()"
            class="btn">

                Imprimir

            </button>

        </div>

    </div>

    {{-- PASOS --}}
    <div class="steps">

        <div class="step">
            <div class="step-circle">1</div>
            Registro
        </div>

        <div class="step">
            <div class="step-circle">2</div>
            Costos
        </div>

        <div class="step">
            <div class="step-circle">3</div>
            Tracking
        </div>

        <div class="step">
            <div class="step-circle">4</div>
            DAM
        </div>

        <div class="step">
            <div class="step-circle">5</div>
            Confirmación
        </div>

    </div>

    <div class="grid">

        {{-- CLIENTE --}}
        <div class="card">

            <h3>Cliente</h3>

            <div class="info">

                <span>Nombre</span>

                <strong>
                    {{ $envio->cliente->nombre_completo ?? '-' }}
                </strong>

            </div>

            <div class="info">

                <span>Documento</span>

                <strong>
                    {{ $envio->cliente->dni ?? $envio->cliente->ruc }}
                </strong>

            </div>

            <div class="info">

                <span>Correo</span>

                <strong>
                    {{ $envio->cliente->correo }}
                </strong>

            </div>

        </div>

        {{-- ENVIO --}}
        <div class="card">

            <h3>Envío</h3>

            <div class="info">

                <span>Peso</span>

                <strong>
                    {{ $envio->peso }} KG
                </strong>

            </div>

            <div class="info">

                <span>Volumen</span>

                <strong>
                    {{ $envio->volumen }}
                </strong>

            </div>

            <div class="info">

                <span>Tipo Envío</span>

                <strong>
                    {{ $envio->tipo_envio }}
                </strong>

            </div>

        </div>

        {{-- COSTOS --}}
        <div class="card">

            <h3>Costos de Envío</h3>

            <table class="table">

                <thead>

                    <tr>

                        <th>Tipo</th>
                        <th>Monto</th>

                    </tr>

                </thead>

                <tbody>

                    @php
                        $totalEnvio = 0;
                    @endphp

                    @foreach($costosEnvio as $costo)

                        @php
                            $totalEnvio += $costo->monto;
                        @endphp

                        <tr>

                            <td>
                                {{ $costo->tipo_costo }}
                            </td>

                            <td>
                                {{ number_format($costo->monto,2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <br>

            <strong>

                Total:
                {{ number_format($totalEnvio,2) }}

            </strong>

        </div>

        {{-- TRACKING --}}
        <div class="card">

            <h3>Tracking</h3>

            @foreach($envio->tracking as $track)

                <div class="info">

                    <span>

                        {{ $track->fecha }}

                    </span>

                    <strong>

                        {{ $track->estado->nombre ?? '-' }}

                    </strong>

                    <br>

                    {{ $track->comentario }}

                </div>

            @endforeach

        </div>

        {{-- DAM --}}
        <div class="card">

            <h3>DAM</h3>

            <div class="info">

                <span>Número DAM</span>

                <strong>
                    {{ $dam->numero_dam ?? '-' }}
                </strong>

            </div>

            <div class="info">

                <span>Canal</span>

                <strong>
                    {{ $dam->canal_control ?? '-' }}
                </strong>

            </div>

            <div class="info">

                <span>Aduana</span>

                <strong>
                    {{ $dam->aduana ?? '-' }}
                </strong>

            </div>

        </div>

        {{-- COSTOS DAM --}}
        <div class="card">

            <h3>Costos Aduaneros</h3>

            <table class="table">

                <thead>

                    <tr>

                        <th>Tipo</th>
                        <th>Monto</th>

                    </tr>

                </thead>

                <tbody>

                    @php
                        $totalDam = 0;
                    @endphp

                    @foreach($costosDam as $costo)

                        @php
                            $totalDam += $costo->monto;
                        @endphp

                        <tr>

                            <td>
                                {{ $costo->tipo_costo }}
                            </td>

                            <td>
                                {{ number_format($costo->monto,2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <br>

            <strong>

                Total Aduanas:
                {{ number_format($totalDam,2) }}

            </strong>

        </div>

    </div>

</div>

</body>
</html>