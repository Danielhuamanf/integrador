@include('layouts.header_cliente')

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f7fb;
}

/* MAIN */

.main{
    flex:1;
    padding:30px;
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

.topbar h1{
    font-size:32px;
    color:#2d2d2d;
    font-weight:700;
}

.actions{
    display:flex;
    gap:12px;
}

/* BUTTONS */

.btn{
    background:linear-gradient(135deg,#6c3ce9,#8b5cf6);
    color:#fff;
    padding:12px 22px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
    box-shadow:0 6px 15px rgba(108,60,233,0.25);
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(108,60,233,0.35);
}

/* GRID */

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:25px;
}

/* CARD */

.card{
    background:#fff;
    padding:25px;
    border-radius:22px;
    box-shadow:0 8px 30px rgba(0,0,0,0.05);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

.card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,#6c3ce9,#a855f7);
}

.card h3{
    margin-bottom:25px;
    color:#222;
    font-size:20px;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:10px;
}

/* INFO */

.info{
    margin-bottom:18px;
    padding-bottom:14px;
    border-bottom:1px dashed #ececec;
}

.info:last-child{
    border-bottom:none;
    margin-bottom:0;
}

.info span{
    display:block;
    color:#8c8c8c;
    font-size:13px;
    margin-bottom:5px;
    font-weight:500;
}

.info strong{
    color:#222;
    font-size:16px;
}

/* TABLE */

.table{
    width:100%;
    border-collapse:collapse;
}

.table thead{
    background:#f7f5ff;
}

.table th{
    padding:14px;
    text-align:left;
    color:#5b34d0;
    font-size:14px;
}

.table td{
    padding:14px;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
}

.table tbody tr:hover{
    background:#faf9ff;
}

/* TOTAL */

.total-box{
    margin-top:20px;
    padding:18px;
    border-radius:15px;
    background:linear-gradient(135deg,#6c3ce9,#8b5cf6);
    color:#fff;
    text-align:center;
    font-size:18px;
    font-weight:700;
    box-shadow:0 8px 20px rgba(108,60,233,0.25);
}

/* TRACKING */

.timeline{
    position:relative;
    padding-left:30px;
}

.timeline::before{
    content:'';
    position:absolute;
    left:8px;
    top:0;
    width:3px;
    height:100%;
    background:#dcd2ff;
}

.timeline-item{
    position:relative;
    margin-bottom:25px;
}

.timeline-item::before{
    content:'';
    position:absolute;
    left:-26px;
    top:5px;
    width:16px;
    height:16px;
    border-radius:50%;
    background:#6c3ce9;
    border:3px solid #fff;
    box-shadow:0 0 0 3px #dcd2ff;
}

.timeline-date{
    color:#888;
    font-size:13px;
    margin-bottom:5px;
}

.timeline-status{
    display:inline-block;
    background:#ede9fe;
    color:#6c3ce9;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    margin-bottom:8px;
}

.timeline-comment{
    color:#444;
    line-height:1.5;
}

/* BADGE */

.badge{
    background:#6c3ce9;
    color:#fff;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

/* RESPONSIVE */

@media(max-width:768px){

    .main{
        padding:20px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .topbar h1{
        font-size:26px;
    }

    .grid{
        grid-template-columns:1fr;
    }

}

</style>
<div class="main">

    <div class="topbar">

        <h1>Detalle de Pedido</h1>

        <div class="actions">


            <button onclick="window.print()"
            class="btn">

                Imprimir

            </button>

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