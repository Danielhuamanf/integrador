<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
</head>
<body>

<h2>Calculadora</h2>

<form method="POST" action="/calcular">
    <?php echo csrf_field(); ?>

    <input type="number" name="num1" required>
    
    <select name="operacion">
        <option value="suma">+</option>
        <option value="resta">-</option>
        <option value="multiplicacion">*</option>
        <option value="division">/</option>
    </select>

    <input type="number" name="num2" required>

    <button type="submit">Calcular</button>
</form>

<?php if(isset($resultado)): ?>
    <h3>Resultado: <?php echo e($resultado); ?></h3>
<?php endif; ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/home.blade.php ENDPATH**/ ?>