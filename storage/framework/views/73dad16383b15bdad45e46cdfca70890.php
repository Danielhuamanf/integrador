<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clientes</title>

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

    .main{
      flex:1;
      padding:25px;
    }

    .topbar{
      justify-content: space-between;
      align-items: center;
      display: flex;
      margin-bottom:25px;
      flex-wrap:wrap;
      gap:15px;
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

    .panel{
      background:#fff;
      padding:25px;
      border-radius:15px;
      box-shadow:0 3px 12px rgba(0,0,0,0.05);
      overflow:auto;
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

    .btn-login{
      padding:12px 18px;
      background:#6c3ce9;
      color:white;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:15px;
      text-decoration:none;
    }

    .id-link{
      color:#4b2ad6;
      font-weight:bold;
      text-decoration:none;
    }

    .id-link:hover{
      text-decoration:underline;
    }

    @media(max-width:900px){
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

  <div class="sidebar">
    <div class="logo">
      <img src="<?php echo e(asset('assets/logo-pasoc.webp')); ?>" width="200">
    </div>

    <div class="menu">
      <a href="<?php echo e(url('/home_admin')); ?>"><i class="fa fa-house"></i> Home</a>
      <a href="<?php echo e(url('/home_admin')); ?>"><i class="fa fa-chart-line"></i> Dashboard</a>
      <a href="<?php echo e(url('ver_ventas')); ?>" class="active"><i class="fa fa-chart-pie"></i> Ventas</a>
      <a href="#"><i class="fa fa-box"></i> Applications</a>
      <a href="#"><i class="fa fa-cubes"></i> Almacen</a>      
      <a href="<?php echo e(url('/ver_clientes')); ?>" ><i class="fa fa-users"></i> Clientes</a>
      <a href="<?php echo e(url('/ver_usuarios')); ?>" ><i class="fa fa-users"></i> Usuarios</a>
      <a href="<?php echo e(url('/ver_leads')); ?>" ><i class="fa fa-users"></i> Leads</a>
    </div>
  </div>

  <div class="main">

    <div class="topbar">
      <h1>Lista de Ordenes</h1>

      <div class="search-box">
        <input type="text" placeholder="Buscar...">
        <i class="fa fa-search"></i>
      </div>

      <a class="btn-login" href="<?php echo e(url('agregar_venta')); ?>">
        Agregar Venta
      </a>
    </div>

    <div class="panel">

      <table>

        <thead>
          <tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>ID</th>
            <th>Estado</th>
            <th>Ingresos</th>
            <th>Fecha</th>
          </tr>
        </thead>

        <tbody>

        <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <?php
            $estadoClass = 'activo';

            if($venta->estado == 'Cancelado'){
              $estadoClass = 'inactivo';
            }

            if($venta->estado == 'Reembolsado'){
              $estadoClass = 'premium';
            }
          ?>

          <tr>

            <td>
              <div class="user">
                <div class="avatar"></div>

                <div>
                  <?php echo e($venta->cliente); ?> <br>

                  <span class="sub">
                    <?php echo e($venta->correo); ?>

                  </span>
                </div>
              </div>
            </td>

            <td>
              <?php if($venta->detalle->count()): ?>
                <?php echo e($venta->detalle->first()->descripcion); ?>

              <?php else: ?>
                Sin detalle
              <?php endif; ?>
            </td>

            <td>
              <a class="id-link"
                 href="<?php echo e(route('ventas.show', $venta->id_envio)); ?>">
                 #<?php echo e($venta->id_envio); ?>

              </a>
            </td>

            <td>
              <div class="status">
                <div class="dot <?php echo e($estadoClass); ?>"></div>
                <?php echo e($venta->estado); ?>

              </div>
            </td>

            <td>
              $<?php echo e(number_format($venta->total, 2)); ?>

            </td>

            <td>
              <?php echo e(\Carbon\Carbon::parse($venta->fecha)->format('d M, Y')); ?>

            </td>

          </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

      </table>

    </div>

  </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/order_list.blade.php ENDPATH**/ ?>