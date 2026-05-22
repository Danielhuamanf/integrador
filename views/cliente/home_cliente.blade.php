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
      text-align: center;
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
    .btn-ventas{
      width:100%;
      padding:14px;
      background:#fff;
      color:black;
      border:solid;
      border-color: #dddddd;
      border-radius:8px;
      cursor:pointer;
      font-size:15px;
      margin-bottom:15px;
    }
    .valor{
      text-align: center;
      color:#4b2ad6;
      font-size: 80px;

    }
  </style>
</head>
<body>

<div class="container">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo"><img src="assets/logo-pasoc.webp" width="200"></div>

    <div class="menu">
      <a href="home_cliente.html" class="active"><i class="fa fa-house"></i> Home</a>
      <a href="chat2.html"><i class="fa fa-message"></i> Chat</a>
      <a href="{{ url('/envios_cliente') }}" ><i class="fa fa-box"></i> Envios</a>
      <a href="configuracion_cliente.html"><i class="fa fa-user"></i> Configuracion</a>
      <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
              <i class="fa fa-sign-out"></i> Cerrar sesión
          </button>
      </form>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

    <div class="topbar">
      <h1>Bienvenido </h1><h1 style="margin-left:10px;"> {{session('usuario_username')}}</h1> 
      <div class="search-box" style="margin-left: 10px;">
        <input type="text" placeholder="Search anything here...">
        <i class="fa fa-search"></i>
      </div>
    </div>

    <!-- CARDS -->


    <!-- TOP GRID -->
    <div class="grid">
      <div class="panel">
        <h3>Pedidos este mes</h3>
        <canvas id="salesChart"></canvas>
      </div>

      <div class="panel">
        <h3>Ulltimo Pedido</h3>
        <div class="shipment-item"><span class="valor">Lima</span></div>
       <a href="envios_cliente.html" class="btn-ventas">Ir a Envios</a>
        
      </div>
    </div>

    <!-- BOTTOM GRID -->


  </div>
</div>

<script>
  // SALES CHART
  new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: ['10','11','12','13','14','15','16','17'],
      datasets: [{
        label: 'Ventas',
        data: [40, 42, 65, 44, 58, 55, 80, 50],
        borderColor: '#6c3ce9',
        backgroundColor: 'rgba(108,60,233,0.15)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      plugins:{legend:{display:false}},
      responsive:true
    }
  });

  // INCOME CHART
  new Chart(document.getElementById('incomeChart'), {
    type: 'line',
    data: {
      labels: ['May5','May6','May7','May8','May9','May10'],
      datasets: [
        {
          label:'Ingresos',
          data:[220,180,200,340,250,150],
          borderColor:'#2ecc71',
          tension:0.4
        },
        {
          label:'Egresos',
          data:[150,160,100,180,90,80],
          borderColor:'#f39c12',
          tension:0.4
        }
      ]
    },
    options:{
      responsive:true
    }
  });
</script>

</body>
</html>