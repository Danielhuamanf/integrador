@include('admin.header')
  <!-- MAIN -->
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
      labels: [<?php foreach ($variable as $key) {
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
