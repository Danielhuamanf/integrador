<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
   .main{
      flex:1;
      padding:25px;
   }
   .topbar{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:20px;
      flex-wrap:wrap;
      gap:10px;
   }
   .topbar h2{
      color:#6c3ce9;
   }
   .right-top{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
   }
   .search{
      padding:10px 15px;
      border-radius:20px;
      border:1px solid #ddd;
      width:250px;
      outline:none;
   }
   .btn-new{
      background:#6c3ce9;
      color:white;
      border:none;
      padding:10px 18px;
      border-radius:10px;
      cursor:pointer;
      font-size:14px;
      transition:.3s;
   }
   .btn-new:hover{
      opacity:.9;
   }
   .card{
      background:#fff;
      border-radius:12px;
      padding:20px;
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
      background:#fafafa;
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
   .user{
      display:flex;
      align-items:center;
      gap:10px;
   }
   .avatar{
      width:40px;
      height:40px;
      border-radius:50%;
      background:#6c3ce9;
      display:flex;
      align-items:center;
      justify-content:center;
      color:white;
      font-weight:bold;
   }
   .actions{
      display:flex;
      gap:8px;
   }
   .btn-action{
      border:none;
      padding:10px;
      border-radius:8px;
      cursor:pointer;
      transition:.3s;
   }
   .edit{
      background:#ede7ff;
      color:#6c3ce9;
   }
   .delete{
      background:#ffe7e7;
      color:red;
   }
   .btn-action:hover{
      transform:scale(1.05);
   }
   .modal{
      display:none;
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background:rgba(0,0,0,.4);
      justify-content:center;
      align-items:center;
      z-index:999;
      padding:15px;
   }
   .modal-content{
      background:white;
      padding:25px;
      border-radius:14px;
      width:500px;
      max-height:90vh;
      overflow:auto;
   }
   .modal-content h2{
      margin-bottom:20px;
      color:#6c3ce9;
   }
   .form-group{
      margin-bottom:12px;
   }
   .form-group input,
   .form-group textarea{
      width:100%;
      padding:12px;
      border:1px solid #ddd;
      border-radius:10px;
      outline:none;
   }
   .modal-buttons{
      display:flex;
      gap:10px;
      margin-top:15px;
   }
   .btn-save{
      background:#6c3ce9;
      color:white;
      border:none;
      padding:12px;
      border-radius:10px;
      cursor:pointer;
      flex:1;
   }
   .btn-close{
      background:#ddd;
      border:none;
      padding:12px;
      border-radius:10px;
      cursor:pointer;
      flex:1;
   }
</style>

<div class="main">
   <div class="topbar">
      <h2>Zonas</h2>

      <div class="right-top">
         <input
            type="text"
            class="search"
            placeholder="Buscar zona..."
            id="buscar">

         <button class="btn-new" onclick="abrirModal()">
            <i class="fa fa-plus"></i> Nueva Zona
         </button>
      </div>
   </div>

   <div class="card">
      <table id="tablaZona">
         <thead>
            <tr>
               <th>Zona</th>
               <th>Descripción</th>
               <th>Dirección</th>
               <th>Acciones</th>
            </tr>
         </thead>

         <tbody>
            <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td>
                  <div class="user">
                     <div class="avatar">
                        <?php echo e(strtoupper(substr($zona->nombre_zona,0,1))); ?>

                     </div>
                     <?php echo e($zona->nombre_zona); ?>

                  </div>
               </td>

               <td><?php echo e($zona->descripcion); ?></td>
               <td><?php echo e($zona->direccion); ?></td>

               <td>
                  <div class="actions">
                     <button
                        type="button"
                        class="btn-action edit"
                        onclick="editarZona(
                           '<?php echo e($zona->id_zona); ?>',
                           '<?php echo e(addslashes($zona->nombre_zona)); ?>',
                           '<?php echo e(addslashes($zona->descripcion)); ?>',
                           '<?php echo e(addslashes($zona->direccion)); ?>'
                        )">
                        <i class="fa fa-pen"></i>
                     </button>

                   
                  </div>
               </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>

<!-- MODAL -->
<div class="modal" id="modalZona">
   <div class="modal-content">
      <h2 id="tituloModal">Nueva Zona</h2>

      <form method="POST" id="formZona">
         <?php echo csrf_field(); ?>

         <div id="methodPut"></div>

         <div class="form-group">
            <input
               type="text"
               name="nombre_zona"
               id="nombre_zona"
               placeholder="Nombre zona"
               required>
         </div>

         <div class="form-group">
            <textarea
               name="descripcion"
               id="descripcion"
               placeholder="Descripción"></textarea>
         </div>

         <div class="form-group">
            <input
               type="text"
               name="direccion"
               id="direccion"
               placeholder="Dirección">
         </div>

         <div class="modal-buttons">
            <button class="btn-save">Guardar</button>

            <button
               type="button"
               class="btn-close"
               onclick="cerrarModal()">
               Cerrar
            </button>
         </div>
      </form>
   </div>
</div>

<script>
   function abrirModal(){
      document.getElementById('modalZona').style.display='flex';
      document.getElementById('tituloModal').innerHTML='Nueva Zona';
      document.getElementById('formZona').action='<?php echo e(route("zonas.store")); ?>';
      document.getElementById('methodPut').innerHTML='';
      document.getElementById('formZona').reset();
   }

   function cerrarModal(){
      document.getElementById('modalZona').style.display='none';
   }

   function editarZona(id,nombre,descripcion,direccion){
      abrirModal();

      document.getElementById('tituloModal').innerHTML='Editar Zona';
      document.getElementById('formZona').action='zonas/update/' + id;
      document.getElementById('methodPut').innerHTML='<?php echo method_field("PUT"); ?>';

      document.getElementById('nombre_zona').value = nombre;
      document.getElementById('descripcion').value = descripcion;
      document.getElementById('direccion').value = direccion;
   }

   document.getElementById('buscar').addEventListener('keyup', function(){
      let filtro = this.value.toLowerCase();
      let filas = document.querySelectorAll('#tablaZona tbody tr');

      filas.forEach(fila => {
         let texto = fila.innerText.toLowerCase();
         fila.style.display = texto.includes(filtro) ? '' : 'none';
      });
   });

   window.onclick = function(event){
      let modal = document.getElementById('modalZona');

      if(event.target == modal){
         cerrarModal();
      }
   }
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/zona_list.blade.php ENDPATH**/ ?>