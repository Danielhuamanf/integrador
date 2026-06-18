<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar contraseña</title>
  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family: Arial, sans-serif;
    }

    body{
      background:#f5f5f5;
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:100vh;
    }

    .forgot-container{
      width:100%;
      max-width:450px;
      background:white;
      padding:50px 40px;
      border-radius:15px;
      box-shadow:0 8px 25px rgba(0,0,0,0.08);
    }

    .forgot-container h2{
      text-align:center;
      font-size:24px;
      color:#333;
      margin-bottom:10px;
    }

    .forgot-container p{
      text-align:center;
      color:#777;
      margin-bottom:30px;
      font-size:14px;
    }

    .input-group{
      margin-bottom:20px;
    }

    .input-group label{
      display:block;
      margin-bottom:8px;
      color:#444;
      font-size:14px;
    }

    .input-group input{
      width:100%;
      padding:14px;
      border:1px solid #ddd;
      border-radius:8px;
      font-size:14px;
      outline:none;
    }

    .btn-reset{
      width:100%;
      padding:14px;
      background:#6c3ce9;
      color:white;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:15px;
      margin-bottom:20px;
    }

    .back-login{
      text-align:center;
    }

    .back-login a{
      color:#6c3ce9;
      text-decoration:none;
      font-size:14px;
    }

    .back-login a:hover{
      text-decoration:underline;
    }
    .alert-error{
    background:#ffe5e5;
    color:#c0392b;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}

.alert-success{
    background:#e8fff0;
    color:#27ae60;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
  </style>
</head>
<body>

  <div class="forgot-container">
    <h2>¿Olvidaste la contraseña?</h2>
    <p>Sigue las instrucciones</p>
    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
      <form method="POST"
        action="{{ route('password.solicitar') }}">

        @csrf

        <div class="input-group">
            <label>Correo</label>
            <input type="email"
                   name="correo"
                   required>
        </div>

       

        <div class="input-group">
            <label>Nueva contraseña</label>
            <input type="password"
                   name="password_nueva"
                   required>
        </div>

        <div class="input-group">
            <label>Confirmar contraseña</label>
            <input type="password"
                   name="password_confirmacion"
                   required>
        </div>
        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin:0;padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button class="btn-reset">
            Solicitar cambio
        </button>

    </form>

    <div class="back-login">
      <a href="login">Back to login</a>
    </div>
  </div>

</body>
</html>