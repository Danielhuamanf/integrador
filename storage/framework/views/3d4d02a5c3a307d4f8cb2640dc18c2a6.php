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
   /* CARD */
   .card{
   background:#fff;
   border-radius:12px;
   padding:20px;
   box-shadow:0 3px 12px rgba(0,0,0,0.05);
   overflow:auto;
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
   background:#6c3ce9;
   display:flex;
   align-items:center;
   justify-content:center;
   color:white;
   font-weight:bold;
   }
   /* ACTIONS */
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
   .products{
   background:#e7f1ff;
   color:#007bff;
   }
   .btn-action:hover{
   transform:scale(1.05);
   }
   /* MODAL */
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
   .form-group select{
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
   .estado{
   padding:6px 12px;
   border-radius:20px;
   font-size:12px;
   font-weight:bold;
   display:inline-block;
   }
   .activo{
   background:#d4edda;
   color:#155724;
   }
   .inactivo{
   background:#f8d7da;
   color:#721c24;
   }
   @media(max-width:900px){
   table{
   font-size:12px;
   min-width:900px;
   }
   }
</style>
<!-- MAIN -->
<div class="main">
   <div class="topbar">
      <h2>Almacenes</h2>
      <div class="right-top">
         <input
            type="text"
            class="search"
            placeholder="Buscar almacén..."
            id="buscar">
         <button class="btn-new" onclick="abrirModal()">
         <i class="fa fa-plus"></i>
         Nuevo Almacén
         </button>
      </div>
   </div>
   <div class="card">
      <table id="tablaAlmacen">
         <thead>
            <tr>
               <th>Almacén</th>
               <th>Dirección</th>
               <th>Responsable</th>
               <th>Teléfono</th>
               <th>Capacidad</th>
               <th>Estado</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $almacenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td>
                  <div class="user">
                     <div class="avatar">
                        <?php echo e(strtoupper(substr($almacen->nombre_almacen,0,1))); ?>

                     </div>
                     <?php echo e($almacen->nombre_almacen); ?>

                  </div>
               </td>
               <td><?php echo e($almacen->direccion); ?></td>
               <td><?php echo e($almacen->nombre_responsable); ?></td>
               <td><?php echo e($almacen->numero_responsable); ?></td>
               <td><?php echo e($almacen->capacidad_m3); ?> m³</td>
               <td>
                  <?php if($almacen->estado == 1): ?>
                  <span class="estado activo">
                  Activo
                  </span>
                  <?php else: ?>
                  <span class="estado inactivo">
                  Inactivo
                  </span>
                  <?php endif; ?>
               </td>
               <td>
				    <div class="actions">

				        <button
				            type="button"
				            class="btn-action edit"
				            onclick="editarAlmacen(
				                '<?php echo e($almacen->id_almacen); ?>',
				                '<?php echo e(addslashes($almacen->nombre_almacen)); ?>',
				                '<?php echo e(addslashes($almacen->direccion)); ?>',
				                '<?php echo e(addslashes($almacen->nombre_responsable)); ?>',
				                '<?php echo e($almacen->numero_responsable); ?>',
				                '<?php echo e($almacen->tipo); ?>',
				                '<?php echo e($almacen->estado); ?>',
				                '<?php echo e($almacen->capacidad_m3); ?>',
				                '<?php echo e($almacen->id_zona); ?>'
				            )">
				            <i class="fa fa-pen"></i>
				        </button>

				        <a
				            class="btn-action delete"
				            href="<?php echo e(url('almacen/delete/'.$almacen->id_almacen)); ?>"
				            onclick="return confirm('¿Eliminar almacén?')">
				            <i class="fa fa-trash"></i>
				        </a>

				        <a
				            class="btn-action products"
				            href="<?php echo e(url('almacen/productos/'.$almacen->id_almacen)); ?>">
				            <i class="fa fa-box"></i>
				        </a>

				    </div>
				</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
</div>
<!-- MODAL -->
<div class="modal" id="modalAlmacen">
   <div class="modal-content">
      <h2 id="tituloModal">
         Nuevo Almacén
      </h2>
      <form method="POST" id="formAlmacen">
         <?php echo csrf_field(); ?>
         <div class="form-group">
            <input
               type="text"
               name="nombre_almacen"
               id="nombre_almacen"
               placeholder="Nombre almacén">
         </div>
         <div class="form-group">
            <input
               type="text"
               name="direccion"
               id="direccion"
               placeholder="Dirección">
         </div>
         <div class="form-group">
            <input
               type="text"
               name="nombre_responsable"
               id="nombre_responsable"
               placeholder="Responsable">
         </div>
         <div class="form-group">
            <input
               type="text"
               name="numero_responsable"
               id="numero_responsable"
               placeholder="Número responsable">
         </div>
         <div class="form-group">
            <select name="tipo" id="tipo">
               <option value="1">Principal</option>
               <option value="2">Secundario</option>
            </select>
         </div>
         <div class="form-group">
            <input
               type="number"
               step="0.01"
               name="capacidad_m3"
               id="capacidad_m3"
               placeholder="Capacidad m3">
         </div>
         <div class="form-group">
            <select name="estado" id="estado">
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
            </select>
         </div>
        <div class="form-group">
		    <select name="id_zona" id="id_zona" required>
		        <option value="">Seleccionar Zona</option>

		        <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <option value="<?php echo e($zona->id_zona); ?>">
		                <?php echo e($zona->nombre_zona); ?>

		            </option>
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		    </select>
		</div>
         <div class="modal-buttons">
            <button class="btn-save">
            Guardar
            </button>
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
   
   document.getElementById('modalAlmacen')
   .style.display='flex';
   
   document.getElementById('tituloModal')
   .innerHTML='Nuevo Almacén';
   
   document.getElementById('formAlmacen')
   .action='<?php echo e(url("almacen/store")); ?>';
   
   document.getElementById('formAlmacen')
   .reset();
   
   }
   
   function cerrarModal(){
   
   document.getElementById('modalAlmacen')
   .style.display='none';
   
   }
   
   function editarAlmacen(
   id,
   nombre,
   direccion,
   responsable,
   numero,
   tipo,
   estado,
   capacidad,
   id_zona
   ){
   
   abrirModal();
   
   document.getElementById('tituloModal')
   .innerHTML='Editar Almacén';
   
   document.getElementById('formAlmacen')
   .action='<?php echo e(url("almacen/update")); ?>/'+id;
   
   document.getElementById('nombre_almacen').value=nombre;
   document.getElementById('direccion').value=direccion;
   document.getElementById('nombre_responsable').value=responsable;
   document.getElementById('numero_responsable').value=numero;
   document.getElementById('tipo').value=tipo;
   document.getElementById('estado').value=estado;
   document.getElementById('capacidad_m3').value=capacidad;
   document.getElementById('id_zona').value=id_zona;
   
   }
   
   /* BUSCADOR */
   
   document.getElementById('buscar')
   .addEventListener('keyup', function(){
   
   let filtro=this.value.toLowerCase();
   
   let filas=document.querySelectorAll(
   '#tablaAlmacen tbody tr'
   );
   
   filas.forEach(fila=>{
   
   let texto=fila.innerText.toLowerCase();
   
   fila.style.display=
   texto.includes(filtro)
   ? ''
   : 'none';
   
   });
   
   });
   
   /* CERRAR MODAL AFUERA */
   
   window.onclick=function(event){
   
   let modal=document.getElementById('modalAlmacen');
   
   if(event.target==modal){
   
   cerrarModal();
   
   }
   
   }
   
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/almacenes.blade.php ENDPATH**/ ?>