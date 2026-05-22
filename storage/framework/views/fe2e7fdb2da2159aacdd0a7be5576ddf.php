<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

        <a href="<?php echo e(route('ventas.pdf', $envio->id_envio)); ?>"
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
                <b><?php echo e($envio->id_envio); ?></b>

                <div class="label">Peso</div>
                <?php echo e($envio->peso); ?>


                <div class="label">Volumen</div>
                <?php echo e($envio->volumen); ?>


                <div class="label">Valor Declarado</div>
                S/ <?php echo e(number_format($envio->valor_declarado,2)); ?>

            </div>

            <div>
                <div class="label">Fecha Envío</div>
                <?php echo e($envio->fecha_envio); ?>


                <div class="label">Fecha Entrega</div>
                <?php echo e($envio->fecha_entrega); ?>


                <div class="label">Descripción</div>
                <?php echo e($envio->descripcion); ?>

            </div>
        </div>
    </div>

    <!-- CLIENTE -->
    <div class="card">
        <h3>Cliente</h3>

        <div class="mini-card">
            <b><?php echo e($envio->cliente->nombre ?? '-'); ?></b>

            <div class="label">Correo</div>
            <?php echo e($envio->cliente->correo ?? '-'); ?>


            <div class="label">Teléfono</div>
            <?php echo e($envio->cliente->telefono ?? '-'); ?>


            <div class="label">Dirección</div>
            <?php echo e($envio->cliente->direccion ?? '-'); ?>

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
                <?php $__empty_1 = true; $__currentLoopData = $envio->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($detalle->producto); ?></td>
                        <td><?php echo e($detalle->cantidad); ?></td>
                        <td><?php echo e($detalle->peso); ?></td>
                        <td><?php echo e($detalle->descripcion); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4">No hay registros</td>
                    </tr>
                <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $envio->tracking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($track->fecha); ?></td>
                        <td>
                            <span class="badge">
                                <?php echo e($track->estado['nombre']); ?>

                            </span>
                        </td>
                        <td><?php echo e($track->comentario); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3">Sin tracking</td>
                    </tr>
                <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $envio->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($doc->nombre); ?></td>
                        <td><?php echo e($doc->descripcion); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2">No hay documentos</td>
                    </tr>
                <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $envio->pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($pago->fecha_pago); ?></td>
                        <td><?php echo e($pago->metodo_pago); ?></td>
                        <td>S/ <?php echo e(number_format($pago->monto,2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3">Sin pagos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- RESUMEN COSTOS -->
    <div class="card">
        <h3>Resumen Financiero</h3>

        <div class="mini-card summary">
            <div>
                <span>Total Costos:</span>
                <span>S/ <?php echo e(number_format($totalCostos,2)); ?></span>
            </div>

            <div>
                <span>Total Pagado:</span>
                <span>S/ <?php echo e(number_format($totalPagado,2)); ?></span>
            </div>

            <div class="total">
                <span>Saldo Pendiente:</span>
                <span>S/ <?php echo e(number_format($saldoPendiente,2)); ?></span>
            </div>
        </div>
    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/order_detail.blade.php ENDPATH**/ ?>