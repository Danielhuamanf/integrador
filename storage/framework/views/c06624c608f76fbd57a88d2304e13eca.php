<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Analytics</title>

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

    /* MAIN */
    .main{
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
      font-size:28px;
    }

    .search-box{
      position:relative;
    }

    .search-box input{
      padding:12px 40px 12px 15px;
      border:1px solid #ddd;
      border-radius:20px;
      width:250px;
      background:#fff;
    }

    .search-box i{
      position:absolute;
      right:15px;
      top:12px;
      color:#888;
    }

    /* CARDS */
    .cards{
      display:grid;
      grid-template-columns:repeat(4,1fr);
      gap:20px;
      margin-bottom:25px;
    }

    .card{
      background:#fff;
      padding:20px;
      border-radius:15px;
      box-shadow:0 3px 12px rgba(0,0,0,0.05);
    }

    .card h4{
      color:#777;
      font-size:14px;
      margin-bottom:10px;
    }

    .card p{
      font-size:28px;
      color:#4b2ad6;
      font-weight:bold;
    }

    /* GRID PANELS */
    .grid{
      display:grid;
      grid-template-columns:2fr 1fr;
      gap:20px;
      margin-bottom:20px;
    }

    .panel{
      background:#fff;
      padding:40px;
      border-radius:15px;
      box-shadow:0 3px 12px rgba(0,0,0,0.05);
    }

    .panel h3{
      margin-bottom:15px;
      color:#444;
    }

    .shipment-item,
    .country-item{
      display:flex;
      justify-content:space-between;
      margin-bottom:15px;
      color:#555;
    }

    .shipment-item i{
      color:#4b2ad6;
      margin-right:8px;
    }

    @media(max-width:1000px){
      .cards{
        grid-template-columns:repeat(2,1fr);
      }

      .grid{
        grid-template-columns:1fr;
      }
    }

    @media(max-width:700px){
      .container{
        flex-direction:column;
      }

      .sidebar{
        width:100%;
      }

      .cards{
        grid-template-columns:1fr;
      }

      .topbar{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
      }
    }
    .subtitulo{

        color: gray;
        font-size: 13px
    }
  </style>
</head>
<body>

<div class="container">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo"><img src="assets/logo-pasoc.webp" width="200"></div>

    <div class="menu">
          <a href="<?php echo e(url('/home_admin')); ?>" class="active"><i class="fa fa-house"></i> Home</a>
      <a href="<?php echo e(url('/home_admin')); ?>"><i class="fa fa-chart-line"></i> Dashboard</a>
      <a href="<?php echo e(url('ver_ventas')); ?>" ><i class="fa fa-chart-pie"></i> Ventas</a>
      <a href="#"><i class="fa fa-box"></i> Applications</a>
      <a href="#"><i class="fa fa-cubes"></i> Almacen</a>      
      <a href="<?php echo e(url('/ver_clientes')); ?>" ><i class="fa fa-users"></i> Clientes</a>
      <a href="<?php echo e(url('/ver_usuarios')); ?>" ><i class="fa fa-users"></i> Usuarios</a>
      <a href="<?php echo e(url('/ver_leads')); ?>" ><i class="fa fa-users"></i> Leads</a>
    </div>
  </div><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/header.blade.php ENDPATH**/ ?>