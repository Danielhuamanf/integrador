<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Usuarios</title>

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

    .input-group{
      margin-bottom:18px;
    }

    .input-group input,
    .input-group select{
      width:100%;
      padding:14px;
      border:1px solid #ddd;
      border-radius:8px;
      outline:none;
      font-size:14px;
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
      margin-top:10px;
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
      <h2>Registrate</h2>

      {{-- ERRORES --}}
      @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      {{-- FORMULARIO --}}
      <form method="POST" action="{{ route('usuario.store') }}">
        @csrf

        <div class="input-group">
          <input type="text" name="username" placeholder="Nombre completo" required>
        </div>

        <div class="input-group">
          <input type="email" name="correo" placeholder="Correo electrónico" required>
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder="Contraseña" required>
        </div>


        <button type="submit" class="btn-login">Registrarme</button>
      </form>

      <div class="register">
        ¿Ya tienes cuenta?
        <a href="{{ url('/login') }}">Inicia sesión</a>
      </div>
    </div>

    <div class="login-right">
      <h2>Bienvenido</h2>
      <p>Regístrate para acceder al sistema</p>
    </div>

  </div>
</div>

</body>
</html>