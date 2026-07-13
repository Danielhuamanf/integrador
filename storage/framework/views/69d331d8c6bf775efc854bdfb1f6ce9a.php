<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<style>
.main{flex:1;padding:30px;background:#f4f6fa;min-height:100vh;}
.topbar{margin-bottom:22px;}
.topbar h1{color:#4b2ad6;font-size:26px;margin:0;}
.topbar a{color:#4b2ad6;text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:5px;margin-top:5px;}
.card{background:#fff;border-radius:12px;box-shadow:0 5px 18px rgba(0,0,0,.08);padding:28px;max-width:920px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{margin-bottom:16px;}
.form-group label{display:block;font-weight:600;font-size:13px;color:#444;margin-bottom:6px;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;outline:none;background:#fff;font-family:inherit;}
.form-group textarea{min-height:130px;resize:vertical;}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#4b2ad6;box-shadow:0 0 0 3px rgba(75,42,214,.1);}
.btn-primary,.btn-secondary{padding:11px 24px;border-radius:10px;font-size:14px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
.btn-primary{background:#4b2ad6;color:#fff;border:none;}
.btn-secondary{background:#fff;color:#666;border:1px solid #ddd;}
.error{background:#f8d7da;color:#721c24;padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;}
@media(max-width:760px){.main{padding:15px;}.form-row{grid-template-columns:1fr;}}
</style>

<div class="main">
    <div class="topbar">
        <h1><i class="fa fa-plus-circle"></i> Nueva Incidencia</h1>
        <a href="<?php echo e(route('incidencias.index')); ?>"><i class="fa fa-arrow-left"></i> Volver a incidencias</a>
    </div>

    <div class="card">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="error"><?php echo e($errors->first()); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('incidencias.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-row">
                <div class="form-group">
                    <label>Remitente</label>
                    <input type="text" name="remitente" value="<?php echo e(old('remitente')); ?>" maxlength="150" placeholder="Nombre del solicitante">
                </div>
                <div class="form-group">
                    <label>Correo electronico</label>
                    <input type="email" name="correo_remitente" value="<?php echo e(old('correo_remitente')); ?>" maxlength="150" placeholder="correo@dominio.com">
                </div>
            </div>

            <div class="form-group">
                <label>Asunto *</label>
                <input type="text" name="titulo" value="<?php echo e(old('titulo')); ?>" required maxlength="200" placeholder="Describe brevemente el problema">
            </div>

            <div class="form-group">
                <label>Descripcion</label>
                <textarea name="descripcion" placeholder="Explica el problema en detalle..."><?php echo e(old('descripcion')); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Modulo afectado</label>
                    <select name="modulo_afectado">
                        <option value="">Sin modulo</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(old('modulo_afectado')==$valor?'selected':''); ?>><?php echo e($texto); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria">
                        <option value="">Sin categoria</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(old('categoria')==$valor?'selected':''); ?>><?php echo e($texto); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Impacto *</label>
                    <select name="impacto" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(old('impacto','medio')==$valor?'selected':''); ?>><?php echo e($texto); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Urgencia *</label>
                    <select name="urgencia" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(old('urgencia','medio')==$valor?'selected':''); ?>><?php echo e($texto); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prioridad manual</label>
                    <select name="prioridad">
                        <option value="">Calcular automaticamente</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $prioridades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(old('prioridad')==$valor?'selected':''); ?>><?php echo e($texto); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Responsable</label>
                    <select name="id_usuario_asignado">
                        <option value="">Sin asignar</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($u->id_usuario); ?>" <?php echo e(old('id_usuario_asignado')==$u->id_usuario?'selected':''); ?>><?php echo e($u->username); ?> (<?php echo e($u->correo); ?>)</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:12px;margin-top:10px;flex-wrap:wrap;">
                <button class="btn-primary"><i class="fa fa-save"></i> Crear Incidencia</button>
                <a href="<?php echo e(route('incidencias.index')); ?>" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\integrador\resources\views/admin/incidencias/create.blade.php ENDPATH**/ ?>