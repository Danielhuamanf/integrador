<!DOCTYPE html>
<html>
<head>
    <title>Editor</title>
</head>
<body>

<h2>Editar Archivo</h2>

<form method="post" action="<?= base_url('repositorio/guardar') ?>">

    <input type="hidden" name="ruta" value="<?= esc($ruta) ?>">

    <textarea
        name="contenido"
        style="width:100%;height:600px;"
    ><?= esc($contenido) ?></textarea>

    <br><br>

    <button type="submit">
        Guardar
    </button>

</form>

</body>
</html>