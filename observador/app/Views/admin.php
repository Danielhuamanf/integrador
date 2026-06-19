<!DOCTYPE html>
<html>
<head>
<title>Panel Administrador</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>

body{
    background:#1e1e1e;
    color:white;
    overflow:hidden;
}

.sidebar{
    width:250px;
    background:#252526;
    height:100vh;
    border-right:1px solid #444;
}

.sidebar a{
    color:#ccc;
    text-decoration:none;
    display:block;
    padding:12px 20px;
}

.sidebar a:hover{
    background:#2d2d2d;
    color:white;
}

.content{
    flex:1;
    overflow:auto;
    padding:25px;
}

.card{
    background:#252526;
    border:none;
    color:white;
}

.table{
    color:white;
}

.form-control,.form-select{
    background:#333;
    color:white;
    border:none;
}

</style>

</head>
<body>

<div class="d-flex">

<div class="sidebar">

    <h4 class="p-3">
        Mini Github
    </h4>

   <a href="#usuarios">
       <i class="bi bi-people-fill"></i> Usuarios
   </a>

   <a href="#actividad">
       <i class="bi bi-clipboard-data"></i> Actividad
   </a>

   <a href="#versiones">
       <i class="bi bi-clock-history"></i> Versiones
   </a>

   <a href="#backups">
       <i class="bi bi-hdd-stack-fill"></i> Backups
   </a>

   <a href="<?= base_url('logout') ?>">
       <i class="bi bi-box-arrow-right"></i> Salir
   </a>

</div>

<div class="content">

    <h2>
        Panel SuperAdmin
    </h2>

    <hr>

    <!-- CREAR USUARIO -->

    <div class="card mb-4" id="usuarios">

        <div class="card-header">
            Crear usuario
        </div>

        <div class="card-body">

            <form action="<?= base_url('admin/guardarUsuario') ?>" method="post">

                <div class="row">

                    <div class="col-md-3">

                        <input
                            class="form-control"
                            name="nombre"
                            placeholder="Nombre"
                            required
                        >

                    </div>

                    <div class="col-md-3">

                        <input
                            class="form-control"
                            name="correo"
                            placeholder="Correo"
                            required
                        >

                    </div>

                    <div class="col-md-3">

                        <input
                            class="form-control"
                            type="password"
                            name="password"
                            placeholder="Contraseña"
                            required
                        >

                    </div>

                    <div class="col-md-2">

                        <select class="form-select" name="rol">

                            <option value="usuario">
                                Usuario
                            </option>

                            <option value="superadmin">
                                SuperAdmin
                            </option>

                        </select>

                    </div>

                    <div class="col-md-1">

                        <button class="btn btn-primary">
                            Crear
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- USUARIOS -->

    <div class="card mb-4">

        <div class="card-header">
            Usuarios
        </div>

        <div class="card-body">

            <table class="table table-dark">

                <thead>

                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach($usuarios as $u): ?>

                    <tr>

                        <td>
                            <?= $u['nombre'] ?>
                        </td>

                        <td>
                            <?= $u['correo'] ?>
                        </td>

                        <td>
                            <?= $u['rol'] ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- ACTIVIDAD -->

    <div class="card mb-4" id="actividad">

        <div class="card-header">
            Últimos movimientos
        </div>

        <div class="card-body">

            <table class="table table-dark">

                <thead>

                    <tr>
                        <th>Usuario</th>
                        <th>Archivo</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach($auditoria as $a): ?>

                    <tr>

                        <td><?= $a['nombre'] ?></td>

                        <td><?= basename($a['archivo']) ?></td>

                        <td><?= $a['accion'] ?></td>

                        <td><?= $a['fecha'] ?></td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- BACKUPS -->

    <div class="card" id="backups">

        <div class="card-header">
            Backups
        </div>

        <div class="card-body">

            <a
                class="btn btn-success"
                href="<?= base_url('admin/crearBackup') ?>"
            >
                Crear Backup
            </a>

            <hr>

            <table class="table table-dark">

                <thead>

                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach($backups as $b): ?>

                    <tr>

                        <td>
                            <?= $b['nombre'] ?>
                        </td>

                        <td>
                            <?= $b['fecha'] ?>
                        </td>

                        <td>

                            <a
                                class="btn btn-warning btn-sm"
                                href="<?= base_url('admin/restaurarBackup/'.$b['id_backup']) ?>"
                            >
                                Restaurar
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

</body>
</html>