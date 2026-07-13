<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $incidencia->codigo }}</title>
</head>
<body style="font-family:Arial,sans-serif;color:#333;line-height:1.5;">
    <h2 style="color:#4b2ad6;margin-bottom:8px;">{{ $incidencia->codigo }}</h2>
    <p>Hola {{ $incidencia->remitente ?: 'estimado usuario' }},</p>
    <p>Tenemos una respuesta para tu incidencia:</p>
    <div style="background:#f6f4ff;border-left:4px solid #4b2ad6;padding:14px 16px;margin:16px 0;">
        {!! nl2br(e($respuesta->comentario)) !!}
    </div>
    <p><strong>Asunto:</strong> {{ $incidencia->titulo }}</p>
    <p><strong>Estado actual:</strong> {{ ucfirst(str_replace('_', ' ', $incidencia->estado)) }}</p>
    <p style="font-size:12px;color:#777;margin-top:24px;">PASOC - Mesa de ayuda</p>
</body>
</html>
