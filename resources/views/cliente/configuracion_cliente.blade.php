<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clientes</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family: Arial, sans-serif;
    }

    body{
      background:#f4f4f7;
    }

    .container{
      display:flex;
      min-height:100vh;
    }

    /* SIDEBAR */
    .sidebar{
      width:240px;
      background:#fff;
      padding:20px;
      box-shadow:2px 0 10px rgba(0,0,0,0.05);
    }

    .logo{
      margin-bottom:30px;
    }

    .menu a{
      display:flex;
      align-items:center;
      gap:12px;
      text-decoration:none;
      color:#666;
      padding:12px 15px;
      margin-bottom:8px;
      border-radius:10px;
      transition:.3s;
    }

    .menu a:hover,
    .menu a.active{
      background:#ede7ff;
      color:#4b2ad6;
    }

    /* MAIN */
    .main{
       background-image: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), 
  url('assets/fondo1.webp');
      
      background-size: cover;
      flex:1;
      padding:25px;
    }

    .topbar{
      display:flex;
      align-items:center;
      margin-bottom:25px;
    }

    .topbar h1{
      color:#4b2ad6;
      font-size:26px;
    }

    .search-box{
      position:relative;
    }

    .search-box input{
      padding:10px 40px 10px 15px;
      border:1px solid #ddd;
      border-radius:20px;
      width:250px;
      background:#fff;
    }

    .search-box i{
      position:absolute;
      right:15px;
      top:10px;
      color:#888;
    }

    /* CARD TABLE */
    .panel{
      background:#ffffffcf;
      padding:25px;
      border-radius:15px;
      box-shadow:0 3px 12px rgba(0,0,0,0.05);
    }

    
    .sub{
      font-size:12px;
      color:#888;
    }

    /* STATUS */
    .status{
      display:flex;
      align-items:center;
      gap:6px;
    }

    .dot{
      width:10px;
      height:10px;
      border-radius:50%;
    }

    .activo{ background:#6c3ce9; }
    .inactivo{ background:#e74c3c; }
    .premium{ background:#3498db; }

    @media(max-width:900px){
      .container{
        flex-direction:column;
      }

      .sidebar{
        width:100%;
      }

    
    }
    .security-container {
  max-width: 700px;
  margin: auto;
  font-family: Arial, sans-serif;
}

.security-card {
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(6px);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

h2 {
  margin-bottom: 20px;
}

h3 {
  margin-bottom: 5px;
}

.subtitle {
  font-size: 13px;
  color: #777;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  font-size: 13px;
  display: block;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ddd;
}

.rules-box {
  background: #f3f3f3;
  padding: 15px;
  border-radius: 8px;
  margin-top: 20px;
  font-size: 13px;
}

.rules-box h4 {
  margin-bottom: 10px;
}

.rules-box ul {
  padding-left: 18px;
}

.rules-box li {
  margin-bottom: 5px;
}

.btn-save {
  margin-top: 20px;
  width: 100%;
  padding: 14px;
  background: #6c3ce9;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

  </style>
</head>

<body>

<div class="container">

  <!-- SIDEBAR (SE CONSERVA) -->
  <div class="sidebar">
    <div class="logo">
      <img src="assets/logo-pasoc.webp" width="200">
    </div>

    <div class="menu">
      <a href="home_cliente.html" ><i class="fa fa-house"></i> Home</a>
      <a href="chat2.html"><i class="fa fa-message"></i> Chat</a>
      <a href="envios_cliente.html"  ><i class="fa fa-box"></i> Envios</a>
      <a href="configuracion_cliente.html" class="active"><i class="fa fa-user"></i> Configuracion</a>
      <a href="index.html"><i class="fa fa-sign-out"></i> Cerrar sesion</a>
      
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

      <div class="topbar">
        <h1>Configuracion Usuario </h1>

       
      </div>

      <!-- TABLA CLIENTES -->
     
    <div class="security-container">

    <h2>Security Setting</h2>

    <div class="security-card">

      <h3>Password</h3>
      <p class="subtitle">
        The Last Pass password generator creates random passwords based on parameters set by you.
      </p>
      <div class="form-group">
        <label>Celular</label>
        <input type="text" placeholder="+51 999 999 999">
      </div>
       <div class="form-group">
        <label>Direccion</label>
        <input type="text" placeholder="Lugar de entrega">
      </div>
       <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="text" placeholder="Email">
      </div>
      <div class="form-group">
        <label>Current password</label>
        <input type="password" placeholder="Current password">
      </div>

      <div class="form-group">
        <label>New password</label>
        <input type="password" placeholder="New password">
      </div>

      <div class="form-group">
        <label>Confirm password</label>
        <input type="password" placeholder="Confirm password">
      </div>

      <div class="rules-box">
        <h4>Rules for password</h4>
        <ul>
          <li>Minimum 8 characters</li>
          <li>At least one special character</li>
          <li>At least one number</li>
          <li>Cannot be the same as previous</li>
        </ul>
      </div>

      <button class="btn-save">Update Password</button>

    </div>

  </div>

    </div>

  </div>


</body>
</html>