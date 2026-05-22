<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

table th,
table td{
    border:1px solid #ddd;
    padding:8px;
}

h2{
    margin-bottom:20px;
}

.section{
    margin-bottom:25px;
}

</style>

</head>

<body>

<h2>
Reporte de Envío #{{ $envio->id_envio }}
</h2>

<div class="section">

    <strong>Cliente:</strong>
    {{ $envio->cliente->nombre_completo ?? '-' }}

    <br>

    <strong>Peso:</strong>
    {{ $envio->peso }}

    <br>

    <strong>Volumen:</strong>
    {{ $envio->volumen }}

</div>

<div class="section">

    <h3>Costos</h3>

    <table>

        <thead>

            <tr>

                <th>Tipo</th>
                <th>Monto</th>

            </tr>

        </thead>

        <tbody>

            @foreach($envio->costos as $costo)

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

</div>

<div class="section">

    <strong>Total Costos:</strong>
    {{ number_format($totalCostos,2) }}

    <br>

    <strong>Total Pagado:</strong>
    {{ number_format($totalPagado,2) }}

    <br>

    <strong>Saldo:</strong>
    {{ number_format($saldoPendiente,2) }}

</div>

</body>
</html>