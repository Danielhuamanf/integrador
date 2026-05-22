<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Palacios & Asociados</title>
  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family: Arial, sans-serif;
    }

    body{
      background:#f5f5f5;
    }

    .container{
      display:flex;
      min-height:100vh;
      align-items:center;
      justify-content:center;
      padding:20px;
    }

    .login-wrapper{
      width:100%;
      max-width:1100px;
      display:grid;
      grid-template-columns:1fr 1fr;
      background:white;
      border-radius:15px;
      overflow:hidden;
      box-shadow:0 10px 30px rgba(0,0,0,0.08);
    }

    .login-left{
      padding:70px;
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .login-left h2{
      font-size:32px;
      margin-bottom:10px;
      color:#111;
    }

    .login-left p{
      color:#777;
      margin-bottom:25px;
      font-size:14px;
    }

    .input-group{
      margin-bottom:18px;
    }

    .input-group label{
      display:block;
      margin-bottom:8px;
      font-size:14px;
      color:#444;
    }

    .input-group input{
      width:100%;
      padding:14px;
      border:1px solid #ddd;
      border-radius:8px;
      outline:none;
      font-size:14px;
    }

    .forgot{
      justify-content: space-between;
      align-items: center;
      display: flex;
      margin-bottom:20px;
    }

    .forgot a{
      text-decoration:none;
      font-size:13px;
      color:#6c3ce9;
    }

    .btn-login{
      width:100%;
      padding:14px;
      background:#6c3ce9;
      color:white;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:15px;
      margin-bottom:15px;
    }

    .social-btn{
      width:100%;
      padding:13px;
      margin-bottom:12px;
      background:white;
      border:1px solid #ddd;
      border-radius:8px;
      cursor:pointer;
    }

    .register{
      text-align:center;
      margin-top:15px;
      font-size:14px;
      color:#777;
    }

    .register a{
      color:#6c3ce9;
      text-decoration:none;
      margin-left:5px;
    }

    .login-right{
      background:#6c3ce9;
      color:white;
      padding:60px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      text-align:center;
    }

    .login-right h1{
      font-size:42px;
      line-height:1.2;
      margin-bottom:20px;
    }

    .login-right p{
      font-size:16px;
      max-width:400px;
      opacity:0.95;
    }

    @media(max-width:900px){
      .login-wrapper{
        grid-template-columns:1fr;
      }

      .login-right{
        display:none;
      }

      .login-left{
        padding:40px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="login-wrapper">

    <div class="login-left">

      <h2>Login</h2>
      
      <p>Logeate con tu correo y tu contraseña</p>
      <form method="POST" action="<?php echo e(url('/loginpost')); ?>">
          <?php echo csrf_field(); ?>

          <div class="input-group">
              <label>Correo Electrónico</label>
              <input type="email" name="correo" placeholder="Correo Electrónico" required>
          </div>

          <div class="input-group">
              <label>Contraseña</label>
              <input type="password" name="password" placeholder="********" required>
          </div>

          <div class="forgot"> 
              <a href="<?php echo e(url('/')); ?>">Regresar</a>
              <a href="#">Olvidé la contraseña</a>
          </div>

          <button class="btn-login" type="submit">Login</button>
                <?php if($errors->any()): ?>
          <p style="color:red; font-size:13px;">
              <?php echo e($errors->first()); ?>

          </p>
      <?php endif; ?>
      </form>
      <button class="social-btn"><img src="assets/google.png" width="15"> Sign in with Google</button>
      <button class="social-btn"><img src="assets/facebook.webp" width="15"> Sign in with Facebook</button>

      <div class="register">
        No tengo una cuenta <a href="<?php echo e(url('/register')); ?>">Regístrate</a>
      </div>
    </div>

    <div class="login-right">
      <img src="assets/logo-w.svg" width="200" style="margin-bottom: 20px;">
      <h2 style="text-align: left;margin-bottom: 60px;" >Para ser parte de nosotros<br>Inicia Sesión</h2>
      <img src="assets/imagen1.png" width="400" style="margin-bottom: 20px;">
    </div>

  </div>
</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/login.blade.php ENDPATH**/ ?>