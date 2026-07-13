<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PASOC|<?php echo e($data['url']); ?></title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
      font-size:22px;
      font-weight:bold;
      color:#4b2ad6;
      margin-bottom:30px;
      line-height:1.3;
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
    @media(max-width:700px){
      .container{
        flex-direction:column;
      }

      .sidebar{
        width:100%;
      }
    }

  </style>
</head>
<body>

<div class="container">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo"><img src="<?php echo e(asset('assets/logo-pasoc.webp')); ?>" width="200"></div>

    <div class="menu">
          <a href="<?php echo e(url('/home_cliente')); ?>" class="<?php echo e($data['url'] == 'home' ? 'active' : ''); ?>"><i class="fa fa-house"></i> Home</a>      
      <a href="<?php echo e(url('/configuracion')); ?>" class="<?php echo e($data['url'] == 'configuracion' ? 'active' : ''); ?>"><i class="fa fa-user-circle"></i> Configuracion</a>
      <a href="<?php echo e(url('/chat/cliente')); ?>" class="<?php echo e($data['url'] == 'Chat' ? 'active' : ''); ?>"><i class="fa fa-users"></i> Chat</a>
      <a href="<?php echo e(url('/envios_cliente')); ?>" class="<?php echo e($data['url'] == 'envios' ? 'active' : ''); ?>"><i class="fa fa-box"></i> Envios</a>
       <a href="<?php echo e(url('/solicitudes')); ?>" class="<?php echo e($data['url'] == 'solicitud' ? 'active' : ''); ?>"><i class="fa fa-box"></i> Solicitud</a>
      <a href="<?php echo e(url('/logout')); ?>" class="<?php echo e($data['url'] == 'logout' ? 'active' : ''); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
    </div>
  </div>  <?php /**PATH D:\xampp\htdocs\integrador\resources\views/layouts/header_cliente.blade.php ENDPATH**/ ?>