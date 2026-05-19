{{-- resources/views/ventas/create.blade.php --}}
@include('layouts.header')

  <style>
    .main{
      flex:1;
      padding:25px;
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

  {{-- MAIN --}}
  <div class="main">

    <div class="topbar">

      <h1>Nueva Venta</h1>

      <div class="actions">

        <a href="{{ route('ventas.index') }}"
        class="btn btn-cancel">
          Cancelar
        </a>

        <button type="submit"
        form="ventaForm"
        class="btn">
          Guardar Venta
        </button>

      </div>

    </div>

    @if ($errors->any())

      <div class="error">

        <ul>

          @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

          @endforeach

        </ul>

      </div>

    @endif

    <form action="{{ route('ventas.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="ventaForm">

      @csrf

      <div class="settings-grid">

        {{-- LEFT --}}
        <div>

          {{-- CLIENTE --}}
          <div class="card">

            <h3>Información del Cliente</h3>

            <div class="row">

              <div class="form-group">
                <label>Cliente / Empresa</label>

               <input type="text"
                  id="cliente"
                  name="cliente"
                  placeholder="Nombre completo">
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

          {{-- ENVIO --}}
          <div class="card">

            <h3>Información del Envío</h3>

            <div class="row">

              <div class="form-group">

                <label>Zona Origen</label>

                <input type="text"
                name="zona_origen"
                placeholder="Origen">

              </div>

              <div class="form-group">

                <label>Zona Destino</label>

                <input type="text"
                name="zona_destino"
                placeholder="Destino">

              </div>

            </div>

            <div class="row">

              <div class="form-group">

                <label>Peso (KG)</label>

                <input type="number"
                step="0.01"
                name="peso"
                placeholder="Peso">

              </div>

              <div class="form-group">

                <label>Total</label>

                <input type="number"
                step="0.01"
                name="total"
                placeholder="Monto total">

              </div>

            </div>

            <div class="row">

              <div class="form-group">

                <label>Alto</label>

                <input type="number"
                step="0.01"
                name="alto"
                placeholder="Alto">

              </div>

              <div class="form-group">

                <label>Ancho</label>

                <input type="number"
                step="0.01"
                name="ancho"
                placeholder="Ancho">

              </div>

              <div class="form-group">

                <label>Largo</label>

                <input type="number"
                step="0.01"
                name="largo"
                placeholder="Largo">

              </div>

            </div>

            <div class="row">

              <div class="form-group">

                <label>Tipo Envío</label>

                <select name="tipo_envio">

                  <option value="">
                    Seleccionar
                  </option>

                  <option value="Marítimo">
                    Marítimo
                  </option>

                  <option value="Aéreo">
                    Aéreo
                  </option>

                  <option value="Terrestre">
                    Terrestre
                  </option>

                  <option value="Courier">
                    Courier
                  </option>

                </select>

              </div>

              <div class="form-group">

                <label>Categoría</label>

                <select name="categoria">

                  <option value="">
                    Seleccionar
                  </option>

                  <option value="Normal">
                    Normal
                  </option>

                  <option value="Fragil">
                    Frágil
                  </option>

                  <option value="Peligrosa">
                    Peligrosa
                  </option>

                </select>

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

        {{-- RIGHT --}}
        <div class="side">

          {{-- DOCUMENTOS --}}
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

          {{-- RESUMEN --}}
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
                {{ now()->format('d/m/Y') }}
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

    fetch(`{{ route('buscar.cliente') }}?buscar=${valor}`)

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
</body>
</html>