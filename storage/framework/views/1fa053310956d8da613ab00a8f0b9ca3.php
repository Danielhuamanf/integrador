<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
.card{
    background: #ffffff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
}

/* TÍTULO */
.card h3{
    font-size: 18px;
    font-weight: 700;
    color: #2b2b2b;
    margin-bottom: 20px;
    letter-spacing: 0.3px;
}

/* =========================
   BLOQUE DE ESTADO ACTUAL
   ========================= */
.estado-box{
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 18px;
    border-radius: 14px;
    background: linear-gradient(135deg, #f7f5ff, #ffffff);
    border: 1px solid #eee;
}

/* ICONO GRANDE */
.estado-icon{
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: #6c3ce9;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(108,60,233,0.25);
}

/* TEXTO PRINCIPAL */
.estado-info h2{
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #1f1f1f;
}

/* SUBTEXTO */
.estado-info small{
    display: block;
    margin-top: 6px;
    color: #888;
    font-size: 12.5px;
}

/* COMENTARIO */
.estado-comentario{
    margin-top: 18px;
    padding: 14px 16px;
    background: #fafafa;
    border-left: 4px solid #6c3ce9;
    border-radius: 10px;
    color: #444;
    font-size: 14px;
    line-height: 1.5;
}

/* UBICACIÓN LINK */
.estado-ubicacion{
    margin-top: 14px;
}

.estado-ubicacion a{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    color: #6c3ce9;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 12px;
    border-radius: 8px;
    background: rgba(108,60,233,0.08);
    transition: 0.2s ease;
}

.estado-ubicacion a:hover{
    background: rgba(108,60,233,0.15);
}
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

/* STEPS */
.steps{
    display:flex;
    justify-content:space-between;
    margin-bottom:25px;
    background:#fff;
    padding:15px;
    border-radius:12px;
}

.step{
    flex:1;
    text-align:center;
    position:relative;
}

.step-circle{
    width:35px;
    height:35px;
    border-radius:50%;
    background:#ddd;
    color:#fff;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:center;
}

.step.active .step-circle{
    background:#6c3ce9;
}

.step-title{
    font-size:12px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

/* CARD */
.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    margin-bottom:20px;
}

/* TIMELINE */
.timeline{
    border-left:3px solid #6c3ce9;
    padding-left:15px;
}

.item{
    margin-bottom:15px;
    position:relative;
}

.dot{
    width:12px;
    height:12px;
    background:#6c3ce9;
    border-radius:50%;
    position:absolute;
    left:-23px;
    top:5px;
}

/* FORM */
input, select, textarea{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}

.btn{
    background:#6c3ce9;
    color:#fff;
    padding:10px;
    border:none;
    border-radius:8px;
    width:100%;
    cursor:pointer;
}


</style>

<div class="main">

    
    <div class="topbar">
        <h1>Seguimiento del Envío #<?php echo e($envio->id_envio); ?></h1>
    </div>

    
    <div class="steps">

        <div class="step active">
            <div class="step-circle">1</div>
            <div>Registro</div>
        </div>

        <div class="step active">
            <div class="step-circle">2</div>
            <div>Costos</div>
        </div>

        <div class="step active">
            <div class="step-circle">3</div>
            <div>Tracking</div>
        </div>

        <div class="step">
            <div class="step-circle">4</div>
            <div>DAM</div>
        </div>

        <div class="step">
            <div class="step-circle">5</div>
            <div>Confirmación</div>
        </div>

    </div>

    <div class="grid">

        
       <div class="card">

    <h3>Estado Actual del Envío</h3>

    <div class="estado-box">

        <div class="estado-icon">
            🚚
        </div>

        <div class="estado-info">

            <h2>
                <?php echo e($tracking->estado->nombre ?? 'Sin estado'); ?>

            </h2>

            <small>
                Última actualización: <?php echo e($tracking->updated_at ?? ''); ?>

            </small>

        </div>

    </div>

    <div class="estado-comentario">

        <?php echo e($tracking->comentario ?? 'Sin comentarios registrados aún.'); ?>


    </div>

    <?php if($tracking && $tracking->ubicacion): ?>

        <div class="estado-ubicacion">

            <a target="_blank"
               href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode($tracking->ubicacion)); ?>">

                📍 Ver en Google Maps

            </a>

        </div>

    <?php endif; ?>

</div>

        
        <div>

            
            <div class="card">

                <h3>Actualizar Tracking</h3>

                <form method="POST"
                      action="<?php echo e(route('ventas.guardar.tracking', $envio->id_envio)); ?>">

                    <?php echo csrf_field(); ?>

                    <label>Estado</label>
                    <select name="id_estado" required>

                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($e->id_estado); ?>"
                                <?php if($tracking && $tracking->id_estado == $e->id_estado): ?> selected <?php endif; ?>>
                                <?php echo e($e->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                    <br><br>

                    <label>Ubicación</label>
                    <input type="text"
                           name="ubicacion"
                           value="<?php echo e($tracking->ubicacion ?? ''); ?>">

                    <br><br>

                    <label>Comentario</label>
                    <textarea name="comentario"><?php echo e($tracking->comentario ?? ''); ?></textarea>

                    <br><br>

                    <button class="btn">
                        Actualizar Tracking
                    </button>
                    <br><br>
                    

                </form>
                    
            </div>

        </div>

    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/add_venta3.blade.php ENDPATH**/ ?>