    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <style>
        .main{
          flex:1;
          padding:25px;
        }

      .steps{
          display:flex;
          align-items:center;
          justify-content:space-between;
          margin-bottom:30px;
          background:#fff;
          padding:20px;
          border-radius:15px;
          box-shadow:0 5px 15px rgba(0,0,0,0.05);
      }

      .step{
          flex:1;
          position:relative;
          text-align:center;
      }

      .step:not(:last-child)::after{
          content:'';
          position:absolute;
          top:20px;
          right:-50%;
          width:100%;
          height:3px;
          background:#ddd;
          z-index:0;
      }

      .step.active:not(:last-child)::after{
          background:#6c3ce9;
      }

      .step-circle{
          width:40px;
          height:40px;
          border-radius:50%;
          background:#ddd;
          color:#fff;
          display:flex;
          align-items:center;
          justify-content:center;
          margin:0 auto 10px;
          font-weight:bold;
          position:relative;
          z-index:1;
      }

      .step.active .step-circle{
          background:#6c3ce9;
      }

      .step-title{
          font-size:13px;
          font-weight:bold;
          color:#555;
      }

      .step.active .step-title{
          color:#6c3ce9;
      }
        .topbar{
          display:flex;
          justify-content:space-between;
          align-items:center;
          margin-bottom:25px;
        }

        .topbar h1{
          color:#4b2ad6;
          font-size:28px;
        }

        .settings-grid{
          display:grid;
          grid-template-columns:2fr 1fr;
          gap:20px;
        }

        .card{
          background:#fff;
          padding:20px;
          border-radius:15px;
          box-shadow:0 5px 15px rgba(0,0,0,0.05);
          margin-bottom:20px;
        }

        .card h3{
          margin-bottom:20px;
          color:#333;
        }

        .row{
          display:flex;
          gap:15px;
        }

        .form-group{
          flex:1;
          margin-bottom:15px;
        }

        .form-group label{
          display:block;
          margin-bottom:6px;
          font-size:13px;
          color:#555;
          font-weight:bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea{
          width:100%;
          padding:12px;
          border-radius:8px;
          border:1px solid #ddd;
          background:#fafafa;
          outline:none;
        }

        .form-group textarea{
          height:100px;
          resize:none;
        }

        .side{
          display:flex;
          flex-direction:column;
          gap:20px;
        }

        .btn{
          background:#6c3ce9;
          color:white;
          padding:12px 18px;
          border:none;
          border-radius:8px;
          cursor:pointer;
          text-decoration:none;
          display:inline-block;
          font-size:15px;
        }

        .btn-cancel{
          background:#eee;
          color:#333;
        }

        .actions{
          display:flex;
          gap:10px;
        }

        .upload-box{
          border:2px dashed #6c3ce9;
          border-radius:10px;
          padding:30px;
          text-align:center;
          color:#6c3ce9;
          background:#faf7ff;
        }

        .summary-item{
          margin-bottom:15px;
        }

        .summary-item span{
          display:block;
          color:#888;
          font-size:13px;
        }

        .summary-item strong{
          font-size:18px;
          color:#333;
        }

        .error{
          background:#ffebeb;
          color:#d63031;
          padding:12px;
          border-radius:8px;
          margin-bottom:20px;
        }

        @media(max-width:900px){

          

          .settings-grid{
            grid-template-columns:1fr;
          }

          .row{
            flex-direction:column;
          }

        }

      </style>

      
      <div class="main">
        
          <div class="topbar">

              <h1>Nueva Operación Logística</h1>

              <div class="actions">

                  <a href="<?php echo e(route('ventas.index')); ?>"
                  class="btn btn-cancel">
                      Cancelar
                  </a>

                  <button type="submit"
                  form="ventaForm"
                  class="btn">
                      Guardar y Continuar
                  </button>

              </div>

          </div>

          
          <div class="steps">

              <div class="step active">

                  <div class="step-circle">
                      1
                  </div>

                  <div class="step-title">
                      Registro
                  </div>

              </div>

              <div class="step">

                  <div class="step-circle">
                      2
                  </div>

                  <div class="step-title">
                      Costos
                  </div>

              </div>

              <div class="step">

                  <div class="step-circle">
                      3
                  </div>

                  <div class="step-title">
                      Tracking
                  </div>

              </div>

              <div class="step">

                  <div class="step-circle">
                      4
                  </div>

                  <div class="step-title">
                      DAM / Aduanas
                  </div>

              </div>

              <div class="step">

                  <div class="step-circle">
                      5
                  </div>

                  <div class="step-title">
                      Confirmación
                  </div>

              </div>

          </div>

        <div class="topbar">

          <h1>Nueva Venta</h1>


        </div>

        <?php if($errors->any()): ?>

          <div class="error">

            <ul>

              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <li><?php echo e($error); ?></li>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

          </div>

        <?php endif; ?>

        <form action="<?php echo e(route('ventas.store')); ?>"
              method="POST"
              enctype="multipart/form-data"
              id="ventaForm">

          <?php echo csrf_field(); ?>
          
          
          <div class="settings-grid">

            
            <div>

              
              <div class="card">

                <h3>Información del Cliente</h3>

                <div class="row">

                  <div class="form-group">
                    <label>Cliente / Empresa</label>

                    <input type="text" id="cliente" name="cliente" placeholder="Nombre completo">
                    <input type="text" id="id_cliente" name="id_cliente" hidden="" value="0">
                  </div>

                  <div class="form-group">
                    <label>Correo</label>

                   <input type="email"
                    id="correo"
                    name="correo"
                    placeholder="Correo">
                  </div>

                </div>

                <div class="row">

                  <div class="form-group">
                    <label>DNI / RUC</label>

                   <input type="text"
                    id="documento"
                    name="documento"
                    placeholder="Ingrese DNI o RUC">
                  </div>

                  <div class="form-group">
                    <label>Celular</label>

                    <input type="text"
                      id="telefono"
                      name="telefono"
                      placeholder="Telefono">
                  </div>

                </div>

                <div class="form-group">

                  <label>Dirección</label>

                  <input type="text"
                  id="direccion"
                  name="direccion"
                  placeholder="Dirección">

                </div>

              </div>

              
              <div class="card">

                <h3>Información del Envío</h3>

                <div class="row">

                  <div class="form-group">

                      <label>Zona Origen</label>

                      <select name="id_zona_origen" id="id_zona_origen">
                          <option value="">Seleccionar</option>

                          <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($zona->id_zona); ?>">
                                  <?php echo e($zona->nombre_zona); ?>

                              </option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>

                  </div>

                  <div class="form-group">

                      <label>Zona Destino</label>

                      <select name="id_zona_destino" id="id_zona_destino">
                          <option value="">Seleccionar</option>

                          <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($zona->id_zona); ?>">
                                  <?php echo e($zona->nombre_zona); ?>

                              </option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>

                  </div>

              </div>

                <div class="row">

                <div class="form-group">

                    <label>Almacén Origen</label>

                    <select name="id_almacen_origen" id="id_almacen_origen">
                        <option value="">Seleccionar</option>
                    </select>

                </div>

                <div class="form-group">

                    <label>Almacén Destino</label>

                    <select name="id_almacen_destino" id="id_almacen_destino">
                        <option value="">Seleccionar</option>
                    </select>

                </div>

            </div>



                <div class="row">

                  <div class="form-group">

                    <label>Alto (metros)</label>

                    <input type="number" step="0.01" name="alto" placeholder="Alto" id="alto">

                  </div>

                  <div class="form-group">

                    <label>Ancho (metros)</label>

                    <input type="number" step="0.01" name="ancho" placeholder="Ancho" id="ancho">

                  </div>

                  <div class="form-group">

                    <label>Largo (metros)</label>

                    <input type="number" step="0.01" name="largo"  placeholder="Largo" id ="largo">

                  </div>

                </div>
                 <div class="row">

                  <div class="form-group">

                    <label>Peso (KG)</label>

                    <input type="number"
                    step="0.01"
                    name="peso"
                    id="peso"
                    placeholder="Peso">

                  </div>
                     <div class="form-group">

                      <label>Volumen</label>

                      <input type="number"
                      step="0.01"
                      name="volumen"
                      id="volumen"
                      readonly>

                  </div>
                    
                </div>
               
                
                <div class="row">

                  <div class="form-group">

                      <label>Fecha Envío</label>

                      <input type="date"
                      name="fecha_envio"
                      value="<?php echo e(date('Y-m-d')); ?>">

                  </div>

                  <div class="form-group">

                      <label>Fecha Entrega</label>

                      <input type="date"
                      name="fecha_entrega">

                  </div>

              </div>
                <div class="row">

                  <div class="form-group">

                    <label>Tipo Envío</label>

                    <select name="tipo_envio" id="tipo_envio">

                       <?php $__currentLoopData = $tipo_envio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo_env): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option value="<?php echo e($tipo_env->id_tipo); ?>">
                                <?php echo e($tipo_env->nombre); ?>

                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     

                    </select>

                  </div>

                </div>
                <div class="row">

                  <div class="form-group">
                      <label>Cantidad</label>

                      <input type="number"
                      name="cantidad">
                  </div>

                  <div class="form-group">
                      <label>Partida Arancelaria</label>

                      <input type="text"
                      name="partida_arancelaria">
                  </div>

              </div>
           <div class="row">

              <div class="form-group">

                  <label>Valor Declarado</label>

                  <input type="number"
                  step="0.01"
                  name="valor_declarado"
                  placeholder="Valor declarado">

              </div>

          </div>

                <div class="form-group">

                  <label>Descripción</label>

                  <textarea
                  name="descripcion"
                  placeholder="Descripción del envío"></textarea>

                </div>

              </div>

            </div>

            
            <div class="side">

              
              <div class="card">

                <h3>Voucher / Documentos</h3>

                <div class="upload-box">

                  <i class="fa fa-cloud-upload-alt"
                  style="font-size:40px;margin-bottom:10px;"></i>

                  <p>
                    Subir documentos
                  </p>

                  <br>

                  <input type="file"
                  name="voucher">

                </div>

              </div>

              
              <div class="card">

                <h3>Resumen</h3>

                <div class="summary-item">
                  <span>Estado</span>

                  <strong>
                    Pendiente
                  </strong>
                </div>

                <div class="summary-item">
                  <span>Fecha</span>

                  <strong>
                    <?php echo e(now()->format('d/m/Y')); ?>

                  </strong>
                </div>

                <div class="summary-item">
                  <span>Moneda</span>

                  <strong>
                    PEN / USD
                  </strong>
                </div>

              </div>

            </div>

          </div>

        </form>

      </div>

    </div>
    <script>

    document.getElementById('documento')
    .addEventListener('keyup', function(){

        let valor = this.value;

        if(valor.length < 8){
            return;
        }

        fetch(`<?php echo e(route('buscar.cliente')); ?>?buscar=${valor}`)

        .then(response => response.json())

        .then(data => {

            if(data.success){

                let cliente = data.cliente;

                document.getElementById('cliente').value =
                    cliente.nombre_completo ?? '';

                document.getElementById('correo').value =
                    cliente.correo ?? '';

                document.getElementById('telefono').value =
                    cliente.telefono ?? '';

                document.getElementById('direccion').value =
                    cliente.direccion ?? '';
                document.getElementById('id_cliente').value =
                    cliente.id_cliente ?? '';    

            }

        })

        .catch(error => {

            console.log(error);

        });

    });

    </script>
    <script>

      function calcularVolumen(){

          let alto = parseFloat(
              document.getElementById('alto').value
          ) || 0;

          let ancho = parseFloat(
              document.getElementById('ancho').value
          ) || 0;

          let largo = parseFloat(
              document.getElementById('largo').value
          ) || 0;

          let volumen = alto * ancho * largo;

          document.getElementById('volumen').value =
              volumen.toFixed(2);

      }


      document.getElementById('alto')
      .addEventListener('keyup', calcularVolumen);

      document.getElementById('ancho')
      .addEventListener('keyup', calcularVolumen);

      document.getElementById('largo')
      .addEventListener('keyup', calcularVolumen);

    </script>
    <script>

    document.getElementById('id_zona_origen').addEventListener('change', function () {

        let zonaId = this.value;

        fetch('almacenes/por-zona/' + zonaId)
            .then(response => response.json())
            .then(data => {

                let select = document.getElementById('id_almacen_origen');

                select.innerHTML = '<option value="">Seleccionar</option>';

                data.forEach(almacen => {

                    select.innerHTML += `
                        <option value="${almacen.id_almacen}">
                            ${almacen.nombre_almacen}
                        </option>
                    `;
                });

            });

    });


    document.getElementById('id_zona_destino').addEventListener('change', function () {

        let zonaId = this.value;

        fetch('almacenes/por-zona/' + zonaId)
            .then(response => response.json())
            .then(data => {

                let select = document.getElementById('id_almacen_destino');

                select.innerHTML = '<option value="">Seleccionar</option>';

                data.forEach(almacen => {

                    select.innerHTML += `
                        <option value="${almacen.id_almacen}">
                            ${almacen.nombre_almacen}
                        </option>
                    `;
                });

            });

    });

    </script>
   

    </body>
    </html><?php /**PATH C:\xampp\htdocs\integrador\resources\views/admin/add_venta.blade.php ENDPATH**/ ?>