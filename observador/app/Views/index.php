<?php 

function mostrarArbol($items)
{
    foreach($items as $item)
    {
        if($item['tipo']=='carpeta')
        {
            ?>
            <details open>
                <summary>📁 <?= $item['nombre'] ?></summary>

                <div class="subcarpeta">
                    <?php mostrarArbol($item['hijos']); ?>
                </div>

            </details>
            <?php
        }
        else
        {
            ?>
            <a
                class="file-link"
                href="<?= base_url('repositorio?archivo='.urlencode($item['ruta'])) ?>"
            >
                📄 <?= $item['nombre'] ?>
            </a>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Mini Github</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    overflow:hidden;
    background:#1e1e1e;
    font-family:Segoe UI;
}

.main{
    display:flex;
    height:100vh;
}

.sidebar{
    width:320px;
    background:#252526;
    border-right:1px solid #333;
    overflow:auto;
    color:white;
}

.sidebar-header{
    padding:15px;
    border-bottom:1px solid #333;
}

.explorer{
    padding:10px;
}

details{
    margin-left:10px;
}

summary{
    cursor:pointer;
    padding:4px;
    user-select:none;
}

summary:hover{
    background:#2d2d2d;
}

.subcarpeta{
    margin-left:15px;
}

.file-link{
    display:block;
    color:#d4d4d4;
    text-decoration:none;
    padding:4px 10px;
    margin-left:20px;
    border-radius:5px;
}

.file-link:hover{
    background:#2d2d2d;
    color:white;
}

.editor-panel{
    flex:1;
    display:flex;
    flex-direction:column;
}

.topbar{
    height:50px;
    background:#2d2d2d;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 20px;
    border-bottom:1px solid #444;
}

#editor{
    flex:1;
}

.bottom{
    background:#252526;
    padding:10px;
    border-top:1px solid #444;
}
.alert{
    border-radius:0;
    margin:0 !important;
}

</style>

</head>
<body>

<div class="main">

    <div class="sidebar">

        <div class="sidebar-header">
            <h5> Proyecto Laravel</h5>
        </div>

        <div class="explorer">

            <?php mostrarArbol($arbol); ?>

        </div>

    </div>

    <div class="editor-panel">

        <form
            action="<?= base_url('repositorio/guardar') ?>"
            method="post"
            style="height:100%;display:flex;flex-direction:column"
        >

            <input
                type="hidden"
                name="ruta"
                value="<?= $archivoSeleccionado ?>"
            >

            <div class="topbar">
                <?php if($soloLectura): ?>

                <div class="alert alert-warning m-2">
                     <?= $mensajeBloqueo ?>
                </div>

                <?php endif; ?>
                <div>
                     <?= basename($archivoSeleccionado ?? 'Sin archivo') ?>
                </div>
                <?= session()->get('nombre') ?>
              <button
                    class="btn btn-primary"
                    <?= $soloLectura ? 'disabled' : '' ?>
                >
                    Guardar

                </button>
                 <a href="<?= base_url('logout_usuario') ?>"  class="btn btn-danger" >
                     Salir
                </a>

            </div>

            <div id="editor"></div>

            <textarea
                id="contenido"
                name="contenido"
                style="display:none"
            ><?= esc($contenido) ?></textarea>

        </form>

    </div>

</div>


<script src="https://unpkg.com/monaco-editor@0.45.0/min/vs/loader.js"></script>

<script>

require.config({
    paths:{
        vs:'https://unpkg.com/monaco-editor@0.45.0/min/vs'
    }
});

require(['vs/editor/editor.main'],function(){

    window.editor=monaco.editor.create(
        document.getElementById('editor'),
        {
            value:document.getElementById('contenido').value,
            language:'php',
            theme:'vs-dark',
            automaticLayout:true,
            fontSize:14,
            readOnly: <?= $soloLectura ? 'true' : 'false' ?>,
            minimap:{
                enabled:true
            }
        }
    );

});

document.querySelector('form').addEventListener('submit',function(){

    document.getElementById('contenido').value=
        editor.getValue();

});

window.addEventListener('beforeunload',function(){

    let archivo="<?= $archivoSeleccionado ?>";

    if(archivo!="")
    {
        navigator.sendBeacon(
            "<?= base_url('repositorio/liberar') ?>",
            new URLSearchParams({
                archivo:archivo
            })
        );
    }

});
</script>

</body>
</html>