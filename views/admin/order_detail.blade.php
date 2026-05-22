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

.title h2{
    color:#6c3ce9;
}

.card{
    background:#fff;
    border-radius:12px;
    padding:25px;
    box-shadow:0 3px 12px rgba(0,0,0,.06);
    margin-bottom:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.mini-card{
    border:1px solid #eee;
    border-radius:12px;
    padding:15px;
}

.label{
    color:#777;
    font-size:13px;
    margin-top:8px;
}

.summary div{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

.total{
    font-weight:bold;
    color:#6c3ce9;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:left;
}

.badge{
    background:#6c3ce9;
    color:white;
    padding:4px 10px;
    border-radius:15px;
    font-size:12px;
}
.btn-pdf{
    background:#e74c3c;
    color:#fff;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
}
</style>

<div class="main">

    <div class="topbar">
        <div class="title">
            <h2>Detalle de Envío Aduanero</h2>
        </div>
         <div>

        <a href="{{ route('ventas.pdf', $envio->id_envio) }}"
        class="btn-pdf">

            Descargar PDF

        </a>

    </div>
    </div>

    <!-- INFORMACIÓN GENERAL -->
    <div class="card">
        <h3>Información General</h3>

        <div class="grid">
            <div>
                <div class="label">Código Envío</div>
                <b>{{ $envio->id_envio }}</b>

                <div class="label">Peso</div>
                {{ $envio->peso }}

                <div class="label">Volumen</div>
                {{ $envio->volumen }}

                <div class="label">Valor Declarado</div>
                S/ {{ number_format($envio->valor_declarado,2) }}
            </div>

            <div>
                <div class="label">Fecha Envío</div>
                {{ $envio->fecha_envio }}

                <div class="label">Fecha Entrega</div>
                {{ $envio->fecha_entrega }}

                <div class="label">Descripción</div>
                {{ $envio->descripcion }}
            </div>
        </div>
    </div>

    <!-- CLIENTE -->
    <div class="card">
        <h3>Cliente</h3>

        <div class="mini-card">
            <b>{{ $envio->cliente->nombre ?? '-' }}</b>

            <div class="label">Correo</div>
            {{ $envio->cliente->correo ?? '-' }}

            <div class="label">Teléfono</div>
            {{ $envio->cliente->telefono ?? '-' }}

            <div class="label">Dirección</div>
            {{ $envio->cliente->direccion ?? '-' }}
        </div>
    </div>

    <!-- DETALLE MERCANCÍA -->
    <div class="card">
        <h3>Mercancía</h3>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Peso</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($envio->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->peso }}</td>
                        <td>{{ $detalle->descripcion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- TRACKING -->
    <div class="card">
        <h3>Tracking</h3>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($envio->tracking as $track)
                    <tr>
                        <td>{{ $track->fecha }}</td>
                        <td>
                            <span class="badge">
                                {{ $track->estado['nombre'] }}
                            </span>
                        </td>
                        <td>{{ $track->comentario }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Sin tracking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- DOCUMENTOS -->
    <div class="card">
        <h3>Documentos</h3>

        <table>
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($envio->documentos as $doc)
                    <tr>
                        <td>{{ $doc->nombre }}</td>
                        <td>{{ $doc->descripcion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay documentos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGOS -->
    <div class="card">
        <h3>Pagos</h3>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Método</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($envio->pagos as $pago)
                    <tr>
                        <td>{{ $pago->fecha_pago }}</td>
                        <td>{{ $pago->metodo_pago }}</td>
                        <td>S/ {{ number_format($pago->monto,2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Sin pagos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- RESUMEN COSTOS -->
    <div class="card">
        <h3>Resumen Financiero</h3>

        <div class="mini-card summary">
            <div>
                <span>Total Costos:</span>
                <span>S/ {{ number_format($totalCostos,2) }}</span>
            </div>

            <div>
                <span>Total Pagado:</span>
                <span>S/ {{ number_format($totalPagado,2) }}</span>
            </div>

            <div class="total">
                <span>Saldo Pendiente:</span>
                <span>S/ {{ number_format($saldoPendiente,2) }}</span>
            </div>
        </div>
    </div>

</div>

</body>
</html>