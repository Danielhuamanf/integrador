<h2>Lista de Usuarios</h2>

<a href="<?php echo e(route('usuarios.create')); ?>">Nuevo Usuario</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Saldo</th>
        <th>Acciones</th>
    </tr>

    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($u->id_usuario); ?></td>
        <td><?php echo e($u->username); ?></td>
        <td><?php echo e($u->saldo); ?></td>
        <td>
            <form action="<?php echo e(route('usuarios.destroy', $u->id_usuario)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table><?php /**PATH C:\xampp\htdocs\integrador\resources\views/usuarios/index.blade.php ENDPATH**/ ?>