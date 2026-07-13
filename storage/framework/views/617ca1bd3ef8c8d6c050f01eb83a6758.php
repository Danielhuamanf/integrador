<?php echo $__env->make('layouts.header_cliente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>

.main{
padding:30px;
background:#f4f7fb;
min-height:100vh;
}

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.title{
font-size:32px;
font-weight:700;
color:#222;
}

.btn{
background:linear-gradient(135deg,#6c3ce9,#8b5cf6);
padding:12px 20px;
border-radius:12px;
color:white;
text-decoration:none;
font-weight:600;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(380px,1fr));
gap:20px;
}

.card{

background:white;

border-radius:20px;

padding:25px;

box-shadow:0 8px 30px rgba(0,0,0,.05);

position:relative;

}

.card::before{

content:'';

position:absolute;

top:0;

left:0;

width:100%;

height:5px;

background:#6c3ce9;

}

.info{

margin-bottom:14px;

}

.info span{

display:block;

font-size:13px;

color:#777;

}

.info strong{

font-size:16px;

}

.estado{

padding:8px 15px;

border-radius:20px;

font-weight:700;

display:inline-block;

}

.PENDIENTE{
background:#fff8db;
color:#aa7b00;
}

.EN_REVISION{
background:#e0ecff;
color:#2f6df6;
}

.APROBADO{
background:#dcffe8;
color:#188d46;
}

.RECHAZADO{
background:#ffe3e3;
color:#d43131;
}

.CERRADO{
background:#ececec;
color:#444;
}

.ATENDIDO{
background:#efe4ff;
color:#7c3aed;
}

</style>

<div class="main">

<div class="topbar">

<div class="title">

Mis Solicitudes

</div>

<a
href="solicitudes/nueva"
class="btn">

* Nueva Solicitud

</a>

</div>

<div class="grid">

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $solicitudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

<div class="card">

<div class="info">

<span>Ticket</span>

<strong>

SOL-
<?php echo e(str_pad($s->id_solicitud,6,'0',STR_PAD_LEFT)); ?>


</strong>

</div>

<div class="info">

<span>Tipo Solicitud</span>

<strong>

<?php echo e(strtoupper($s->tipo)); ?>


</strong>

</div>

<div class="info">

<span>Motivo</span>

<strong>

<?php echo e($s->motivo); ?>


</strong>

</div>

<div class="info">

<span>Envío</span>

<strong>

#<?php echo e($s->id_envio); ?>


</strong>

</div>

<div class="info">

<span>Estado</span>

<div class="estado <?php echo e($s->estado); ?>">

<?php echo e($s->estado); ?>


</div>

</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($s->respuesta): ?>

<div class="info">

<span>Respuesta</span>

<strong>

<?php echo e($s->respuesta); ?>


</strong>

</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="info">

<span>Fecha</span>

<strong>

<?php echo e($s->created_at); ?>


</strong>

</div>

</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

</div>

</div>

</body>
</html>
<?php /**PATH D:\xampp\htdocs\integrador\resources\views/cliente/solicitud_lista.blade.php ENDPATH**/ ?>