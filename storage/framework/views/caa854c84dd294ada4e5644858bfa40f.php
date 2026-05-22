<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

        
        <div class="card">

            <h3>Información DAM</h3>

            <form method="POST"
            action="<?php echo e(route('ventas.guardar.dam', $envio->id_envio)); ?>">

                <?php echo csrf_field(); ?>

                <div class="form-group">

                    <label>Número DAM</label>

                    <input type="text"
                    name="numero_dam"
                    value="<?php echo e($dam->numero_dam); ?>">

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
                    value="<?php echo e($dam->fecha_numeracion); ?>">

                </div>

                <div class="form-group">

                    <label>Aduana</label>

                    <input type="text"
                    name="aduana"
                    value="<?php echo e($dam->aduana); ?>">

                </div>

                <div class="form-group">

                    <label>Estado</label>

                    <input type="text"
                    name="estado"
                    value="<?php echo e($dam->estado); ?>">

                </div>

                <button class="btn">

                    Guardar DAM

                </button>

            </form>
            <br>
            <button class="btn" onclick="location.href = ' <?php echo e(route('ventas.confirmacion', $envio->id_envio)); ?>';" >Siguiente</button>
           
        </div>

        
        <div class="card">

            <h3>Costos Aduaneros</h3>

            <form method="POST"
            action="<?php echo e(route('ventas.guardar.costo.dam', $envio->id_envio)); ?>">

                <?php echo csrf_field(); ?>

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

                    <?php
                        $total = 0;
                    ?>

                    <?php $__currentLoopData = $costos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $total += $costo->monto;
                        ?>

                        <tr>

                            <td>
                                <?php echo e($costo->tipo_costo); ?>

                            </td>

                            <td>
                                <?php echo e($costo->monto); ?>

                            </td>

                            <td>
                                <?php echo e($costo->moneda); ?>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>

            </table>

            <div class="total-box">

                <strong>

                    Total Aduanero:
                    <?php echo e(number_format($total,2)); ?>


                </strong>

            </div>

        </div>

    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/add_venta4.blade.php ENDPATH**/ ?>