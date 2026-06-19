<!DOCTYPE html>
<html>
<head>

<title>Mini Github</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#1e1e1e;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:400px;
    background:#252526;
    color:white;
    border:none;
}

.form-control{
    background:#333;
    border:none;
    color:white;
}

.form-control:focus{
    background:#333;
    color:white;
}

</style>

</head>
<body>

<div class="card shadow">

    <div class="card-body">

        <h3 class="text-center mb-4">
            Mini Github
        </h3>

        <?php if(session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">

                <?= session()->getFlashdata('error') ?>

            </div>

        <?php endif; ?>

        <form action="<?= base_url('login/validar') ?>" method="post">

            <div class="mb-3">

                <label>Correo</label>

                <input
                    type="email"
                    name="correo"
                    class="form-control"
                    required
                >

            </div>

            <div class="mb-3">

                <label>Contraseña</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>

            <button class="btn btn-primary w-100">

                Ingresar

            </button>

        </form>

    </div>

</div>

</body>
</html>