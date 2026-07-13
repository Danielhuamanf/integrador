<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($incidencia->codigo); ?></title>
</head>
<body style="font-family:Arial,sans-serif;color:#333;line-height:1.5;">
    <h2 style="color:#4b2ad6;margin-bottom:8px;"><?php echo e($incidencia->codigo); ?></h2>
    <p>Hola <?php echo e($incidencia->remitente ?: 'estimado usuario'); ?>,</p>
    <p>Tenemos una respuesta para tu incidencia:</p>
    <div style="background:#f6f4ff;border-left:4px solid #4b2ad6;padding:14px 16px;margin:16px 0;">
        <?php echo nl2br(e($respuesta->comentario)); ?>

    </div>
    <p><strong>Asunto:</strong> <?php echo e($incidencia->titulo); ?></p>
    <p><strong>Estado actual:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $incidencia->estado))); ?></p>
    <p style="font-size:12px;color:#777;margin-top:24px;">PASOC - Mesa de ayuda</p>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\integrador\resources\views/emails/incidencia_respuesta.blade.php ENDPATH**/ ?>