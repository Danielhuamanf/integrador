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

    table{
      width:100%;
      border-collapse:collapse;
    }

    th{
      text-align:left;
      padding:15px 10px;
      color:#888;
      font-size:14px;
      font-weight:500;
    }

    td{
      padding:15px 10px;
      border-top:1px solid #eee;
      font-size:14px;
    }

    tr:hover{
      background:#fafafa;
    }

    /* USER */
    .user{
      display:flex;
      align-items:center;
      gap:10px;
    }

    .avatar{
      width:40px;
      height:40px;
      border-radius:50%;
      background:#ddd;
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

      table{
        font-size:12px;
      }
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
      <a href="envios_cliente.html" class="active" ><i class="fa fa-box"></i> Envios</a>
      <a href="configuracion_cliente.html"><i class="fa fa-user"></i> Configuracion</a>
      <a href="index.html"><i class="fa fa-sign-out"></i> Cerrar sesion</a>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

    <div class="topbar">
      <h1>Lista de Ordenes </h1>

      <div class="search-box">
         <input type="text" placeholder="Search anything here...">
        <i class="fa fa-search"></i>
      </div>
    </div>

    <!-- TABLA CLIENTES -->
    <div class="panel">

      <table>
        <thead>
          <tr>
           
            <th>Producto</th>
            <th>ID</th>
            <th>Estado</th>
            <th>Ingresos</th>
            <th>Fecha</th>
          </tr>
        </thead>

        <tbody>
          
          <tr>
          
            <td>Envío a Perú - Lima</td>
            <td><a href="order_detail.html">#10421</a></td>
            <td>
              <div class="status">
                <div class="dot activo"></div> Paid
              </div>
            </td>
            <td>$735.2</td>
            <td>12 Jan, 2023</td>
          </tr>
          
          <tr>
            
            <td>Envío a Perú - Arequipa</td>
            <td><a href="order_detail.html">#10422</a></td>
            <td>
              <div class="status">
                <div class="dot inactivo"></div> Canceled
              </div>
            </td>
            <td>$877.12</td>
            <td>13 Jan, 2023</td>
          </tr>

          <tr>
           
            <td>Envío a México - Jalisco</td>
            <td><a href="order_detail.html">#10423</a></td>
            <td>
              <div class="status">
                <div class="dot premium"></div> Refunded
              </div>
            </td>
            <td>$134.72</td>
            <td>14 Jan, 2023</td>
          </tr>

        </tbody>
      </table>

    </div>

  </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/cliente/envios_cliente.blade.php ENDPATH**/ ?>