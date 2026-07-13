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
    font-size:28px;
    margin:0;
}

.panel{
    background:#fff;
    border-radius:15px;
    padding:30px;
    box-shadow:0 3px 12px rgba(0,0,0,.05);
}

.detalle-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    margin-top:20px;
}

.card-info{
    background:#fafafa;
    border:1px solid #eee;
    border-radius:12px;
    padding:18px;
}

.card-info label{
    display:block;
    font-size:12px;
    color:#888;
    margin-bottom:8px;
    text-transform:uppercase;
    font-weight:bold;
}

.card-info span{
    font-size:15px;
    color:#333;
}

.card-full{
    grid-column:1 / -1;
}

.estado{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-weight:bold;
}

.dot{
    width:12px;
    height:12px;
    border-radius:50%;
}

.abierto{
    background:#f39c12;
}

.proceso{
    background:#3498db;
}

.cerrado{
    background:#2ecc71;
}

.rechazado{
    background:#e74c3c;
}

.aprobado{
    background:#27ae60;
}

.actions{
    margin-top:30px;
    display:flex;
    gap:10px;
}

.btn{
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:14px;
}

.btn-back{
    background:#7f8c8d;
}

.btn-edit{
    background:#6c3ce9;
}

.avatar{
    width:70px;
    height:70px;
    border-radius:50%;
    background:#e5e5e5;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
    color:#666;
}

.cliente-box{
    display:flex;
    gap:15px;
    align-items:center;
    margin-bottom:20px;
}

.cliente-info h3{
    margin:0;
    color:#333;
}

.cliente-info p{
    margin:5px 0 0;
    color:#888;
}

@media(max-width:768px){

    .detalle-grid{
        grid-template-columns:1fr;
    }

}

</style>

<div class="main">

    <div class="topbar">
        <h1>Detalle de Solicitud</h1>
    </div>

    <div class="panel">

        <div class="cliente-box">

            <div class="avatar">
                <i class="fa fa-user"></i>
            </div>

            <div class="cliente-info">

                <h3>
                    <?php echo e($solicitud->cliente->nombre_completo ?? 'Cliente'); ?>

                </h3>

                <p>
                    <?php echo e($solicitud->cliente->correo ?? '-'); ?>

                </p>

            </div>

        </div>

        <?php

            $estadoClass='abierto';

            if(strtolower($solicitud->estado)=='en proceso'){
                $estadoClass='proceso';
            }

            if(strtolower($solicitud->estado)=='cerrado'){
                $estadoClass='cerrado';
            }

            if(strtolower($solicitud->estado)=='rechazado'){
                $estadoClass='rechazado';
            }

            if(strtolower($solicitud->estado)=='aprobado'){
                $estadoClass='aprobado';
            }

        ?>

        <div class="detalle-grid">

            <div class="card-info">
                <label>ID Solicitud</label>
                <span>#SOL-<?php echo e($solicitud->id_solicitud); ?></span>
            </div>

            <div class="card-info">
                <label>ID Envío</label>
                <span>#<?php echo e($solicitud->id_envio); ?></span>
            </div>

            <div class="card-info">
                <label>Tipo</label>
                <span><?php echo e(strtoupper($solicitud->tipo)); ?></span>
            </div>

            <div class="card-info">
                <label>Estado</label>

                <span class="estado">
                    <div class="dot <?php echo e($estadoClass); ?>"></div>
                    <?php echo e($solicitud->estado); ?>

                </span>

            </div>

            <div class="card-info card-full">
                <label>Motivo de la Solicitud</label>
                <span><?php echo e($solicitud->motivo); ?></span>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($solicitud->respuesta)): ?>

            <div class="card-info card-full">
                <label>Respuesta del Operador</label>
                <span><?php echo e($solicitud->respuesta); ?></span>
            </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($solicitud->created_at): ?>

            <div class="card-info">
                <label>Fecha Registro</label>
                <span>
                    <?php echo e(\Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i')); ?>

                </span>
            </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>

        <div class="actions">

            <a href="<?php echo e(url('operador/solicitudes')); ?>"
               class="btn btn-back">
                Volver
            </a>

           

        </div>

    </div>

</div>

</body>
</html><?php /**PATH D:\xampp\htdocs\integrador\resources\views/admin/ver_solicitud.blade.php ENDPATH**/ ?>