@include('layouts.header')
  <style>
    .main{
      flex:1;
      padding:25px;
    }

    .topbar{
      justify-content: space-between;
      align-items: center;
      display: flex;
      margin-bottom:25px;
      flex-wrap:wrap;
      gap:15px;
    }

    .topbar h1{
      color:#4b2ad6;
      font-size:26px;
    }

    .search-box{
      position:relative;
    }

    .search-box input{
      padding:10px 40px 10px 15px;
      border:1px solid #ddd;
      border-radius:20px;
      width:250px;
      background:#fff;
    }

    .search-box i{
      position:absolute;
      right:15px;
      top:10px;
      color:#888;
    }

    .panel{
      background:#fff;
      padding:25px;
      border-radius:15px;
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
    }

    td{
      padding:15px 10px;
      border-top:1px solid #eee;
      font-size:14px;
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
      background:#ddd;
    }

    .sub{
      font-size:12px;
      color:#888;
    }

    .status{
      display:flex;
      align-items:center;
      gap:6px;
    }

    .dot{
      width:10px;
      height:10px;
      border-radius:50%;
    }

    .activo{ background:#6c3ce9; }
    .inactivo{ background:#e74c3c; }
    .premium{ background:#3498db; }

    .btn-login{
      padding:12px 18px;
      background:#6c3ce9;
      color:white;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:15px;
      text-decoration:none;
    }

    .id-link{
      color:#4b2ad6;
      font-weight:bold;
      text-decoration:none;
    }

    .id-link:hover{
      text-decoration:underline;
    }

  </style>


  <div class="main">

    <div class="topbar">
      <h1>Lista de Pedidos</h1>

      <div class="search-box">
        <input type="text" placeholder="Buscar...">
        <i class="fa fa-search"></i>
      </div>

      <a class="btn-login" href="{{url('agregar_venta')}}">
        Agregar Venta
      </a>
    </div>

    <div class="panel">

      <table>

        <thead>
          <tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>ID</th>
            <th>Estado</th>
            <th>Ingresos</th>
            <th>Fecha</th>
          </tr>
        </thead>

       <tbody>

@foreach($ventas as $venta)

    @php

        $estadoClass = 'activo';

        if($venta->estado == 2){
            $estadoClass = 'premium';
        }

        if($venta->estado == 3){
            $estadoClass = 'inactivo';
        }

    @endphp

    <tr>

        {{-- CLIENTE --}}
        <td>

            <div class="user">

                <div class="avatar"></div>

                <div>

                    {{ $venta->cliente->nombre_completo ?? 'Sin cliente' }}

                    <br>

                    <span class="sub">

                        {{ $venta->cliente->correo ?? '-' }}

                    </span>

                </div>

            </div>

        </td>

        {{-- DESCRIPCION --}}
        <td>

            {{ $venta->descripcion ?? 'Sin descripción' }}

        </td>

        {{-- ID --}}
        <td>

            <a class="id-link"
               href="{{ route('envios.detalle', $venta->id_envio,'/detalle') }}">

                #{{ $venta->id_envio }}

            </a>

        </td>

        {{-- ESTADO --}}
        <td>

            <div class="status">

                <div class="dot {{ $estadoClass }}"></div>

                {{ $venta->estado_envio->nombre_estado ?? 'Pendiente' }}

            </div>

        </td>

        {{-- TIPO ENVIO --}}
        <td>

            {{ $venta->tipo->nombre_tipo_envio ?? '-' }}

        </td>

        {{-- FECHA --}}
        <td>

            @if($venta->fecha_envio)

                {{ \Carbon\Carbon::parse(
                    $venta->fecha_envio
                )->format('d/m/Y') }}

            @else

                -

            @endif

        </td>

    </tr>

@endforeach

</tbody>

      </table>

    </div>

  </div>

</div>

</body>
</html>