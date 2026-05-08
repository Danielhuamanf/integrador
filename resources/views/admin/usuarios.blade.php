<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clientes</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}
body{background:#f4f5fb;}

.container{display:flex;min-height:100vh;}

/* SIDEBAR */
.sidebar{
  width:240px;background:#fff;padding:20px;
  box-shadow:2px 0 10px rgba(0,0,0,0.05);
}
.logo{margin-bottom:30px;}
.menu a{
  display:flex;align-items:center;gap:12px;
  text-decoration:none;color:#666;
  padding:12px;border-radius:10px;margin-bottom:8px;
}
.menu a.active,.menu a:hover{
  background:#ede7ff;color:#6c3ce9;
}

/* MAIN */
.main{flex:1;padding:25px;}

.topbar{
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-bottom:20px;
}

.topbar h2{
  color:#6c3ce9;
}

.search{
  padding:10px 15px;
  border-radius:20px;
  border:1px solid #ddd;
  width:250px;
}

/* TABLE CARD */
.card{
  background:#fff;
  border-radius:12px;
  padding:20px;
  box-shadow:0 3px 12px rgba(0,0,0,0.05);
}

/* TABLE */
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
  color:#555;
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

/* RESPONSIVE */
@media(max-width:900px){
  table{
    font-size:12px;
  }

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
  <div class="logo">
    <img src="assets/logo-pasoc.webp" width="200">
  </div>

  <div class="menu">
   <a href="home.html"><i class="fa fa-house"></i> Home</a>
      <a href="dashboard.html"><i class="fa fa-chart-line"></i> Dashboard</a>
      <a href="order_list.html" ><i class="fa fa-chart-pie"></i> Ventas</a>
      <a href="chat.html"><i class="fa fa-box"></i> Applications</a>
      <a href="almacen.html"><i class="fa fa-cubes"></i> Almacen</a>
      <a href="usuarios.html" class="active"><i class="fa fa-users"></i> Usuarios</a>
  </div>
</div>

<!-- MAIN -->
<div class="main">

  <div class="topbar">
    <h2>Usuarios</h2>
    <input class="search" placeholder="Search anything here...">
  </div>

  <div class="card">

    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Rol</th>
          <th>Correo</th>
          <th>Celular</th>
          <th>Creado en</th>
        </tr>
      </thead>

     <tbody>

      @foreach($usuarios as $usuario)

      <tr>
        <td>
          <div class="user">
            <div class="avatar"></div>
            {{ $usuario->nombre }}
          </div>
        </td>
        <td>{{ $usuario->rol }}</td>

        <td>{{ $usuario->correo }}</td>

        <td>---</td>

        <td>{{ $usuario->created_at ?? '---' }}</td>
      </tr>

      @endforeach

      </tbody>

    </table>

  </div>

</div>

</div>

</body>
</html>