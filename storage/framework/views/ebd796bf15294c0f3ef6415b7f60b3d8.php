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
Reporte de Envío #<?php echo e($envio->id_envio); ?>

</h2>

<div class="section">

    <strong>Cliente:</strong>
    <?php echo e($envio->cliente->nombre_completo ?? '-'); ?>


    <br>

    <strong>Peso:</strong>
    <?php echo e($envio->peso); ?>


    <br>

    <strong>Volumen:</strong>
    <?php echo e($envio->volumen); ?>


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

            <?php $__currentLoopData = $envio->costos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <td>
                        <?php echo e($costo->tipo_costo); ?>

                    </td>

                    <td>
                        <?php echo e(number_format($costo->monto,2)); ?>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

    </table>

</div>

<div class="section">

    <strong>Total Costos:</strong>
    <?php echo e(number_format($totalCostos,2)); ?>


    <br>

    <strong>Total Pagado:</strong>
    <?php echo e(number_format($totalPagado,2)); ?>


    <br>

    <strong>Saldo:</strong>
    <?php echo e(number_format($saldoPendiente,2)); ?>


</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/envio.blade.php ENDPATH**/ ?>