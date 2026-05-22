<h2>Nuevo Usuario</h2>

<form action="<?php echo e(route('usuarios.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <label>Usuario:</label>
    <input type="text" name="username"><br>

    <label>Password:</label>
    <input type="text" name="password"><br>

    <label>Saldo:</label>
    <input type="number" name="saldo"><br>

    <button type="submit">Guardar</button>
</form><?php /**PATH C:\xampp\htdocs\integrador\resources\views/usuarios/create.blade.php ENDPATH**/ ?>