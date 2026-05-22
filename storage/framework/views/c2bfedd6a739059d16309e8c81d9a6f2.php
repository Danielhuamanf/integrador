<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

      <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <tr>
        <td>
          <div class="user">
            <div class="avatar"></div>
            <?php echo e($usuario->nombre); ?>

          </div>
        </td>
        <td><?php echo e($usuario->rol); ?></td>

        <td><?php echo e($usuario->correo); ?></td>

        <td>---</td>

        <td><?php echo e($usuario->created_at ?? '---'); ?></td>
      </tr>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      </tbody>

    </table>

  </div>

</div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/usuarios.blade.php ENDPATH**/ ?>