<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <!-- MAIN -->
  <style>
    
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
  <div class="main">

    <div class="topbar">
      <h1>Analytics </h1>
      <div class="search-box" style="margin-left: 10px;">
        <input type="text" placeholder="Search anything here...">
        <i class="fa fa-search"></i>
      </div>
    </div>

    <!-- CARDS -->
    <div class="cards">
      <div class="card">
        <h4>Gastos</h4>
        <p>$1,567.99</p>
        <label class="subtitulo">WE, jul, 2020</label>
      </div>
      <div class="card">
        <h4>Ingresos</h4>
        <p>$2,868.99</p>
        <label class="subtitulo">WE, jul, 2020</label>
      </div>
      <div class="card">
        <h4>Envíos</h4>
        <p>156k</p>
        <label class="subtitulo">WE, jul, 2020</label>
      </div>
      <div class="card">
        <h4>Clientes</h4>
        <p>3,422</p>
        <label class="subtitulo">WE, jul, 2020</label>
      </div>
    </div>

    <!-- TOP GRID -->
    <div class="grid">
      <div class="panel">
        <h3>Ventas</h3>
        <canvas id="salesChart"></canvas>
      </div>

      <div class="panel">
        <h3>Envíos</h3>
        <div class="shipment-item"><span><i class="fa fa-plane"></i>Aéreos</span><span>96.42%</span></div>
        <div class="shipment-item"><span><i class="fa fa-truck"></i>Terrestres</span><span>2.76%</span></div>
        <div class="shipment-item"><span><i class="fa fa-ship"></i>Barco</span><span>20.76%</span></div>
      </div>
    </div>

    <!-- BOTTOM GRID -->
    <div class="grid">
      <div class="panel">
        <h3>Egresos e ingresos</h3>
        <canvas id="incomeChart"></canvas>
      </div>

      <div class="panel">
        <h3>Últimos envíos</h3>
        <div class="country-item"><span>Pakistan</span><span>54%</span></div>
        <div class="country-item"><span>Germany</span><span>32%</span></div>
        <div class="country-item"><span>USA</span><span>27%</span></div>
        <div class="country-item"><span>Spain</span><span>25%</span></div>
      </div>
    </div>

  </div>
</div>

<script>
  // SALES CHART
  new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: [<?php foreach ($data['variable'] as $key) {
        echo "'".$key['value']."',";
      }?>'10','11','12','13','14','15','16','17'],
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
<?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>