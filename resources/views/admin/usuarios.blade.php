@include('layouts.header')
<style>

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
}

</style>

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