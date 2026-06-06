@include('layouts.header_cliente')

<style>

.main{
padding:30px;
background:#f4f7fb;
min-height:100vh;
}

.card{

max-width:900px;

margin:auto;

background:white;

padding:35px;

border-radius:25px;

box-shadow:0 10px 35px rgba(0,0,0,.05);

}

h1{

margin-bottom:25px;

}

.group{

margin-bottom:22px;

}

label{

display:block;

margin-bottom:8px;

font-weight:600;

}

input,
select,
textarea{

width:100%;

padding:14px;

border:1px solid #ddd;

border-radius:12px;

}

textarea{

height:140px;

resize:none;

}

.btn{

background:linear-gradient(135deg,#6c3ce9,#8b5cf6);

color:white;

border:none;

padding:14px 25px;

border-radius:12px;

cursor:pointer;

}

</style>

<div class="main">

<div class="card">

<h1>Nueva Solicitud</h1>

<form
method="POST"
action="/cliente/solicitudes">

@csrf

<div class="group">

<label>Envío</label>

<select
name="id_envio"
required>

<option value="">

Seleccione

</option>

@foreach($envios as $envio)

<option
value="{{ $envio->id_envio }}">

ENV-
{{ $envio->id_envio }}

—

{{ $envio->tipo_envio }}

</option>

@endforeach

</select>

</div>

<div class="group">

<label>Tipo de Solicitud</label>

<select
name="tipo">

<option value="tracking">

Estado Tracking

</option>

<option value="estado_envio">

Estado Envío

</option>

<option value="dam">

Consulta DAM

</option>

<option value="documentos">

Solicitar Documentos

</option>

</select>

</div>

<div class="group">

<label>Detalle</label>

<textarea
name="motivo"
required>
</textarea>

</div>

<button
class="btn">

Registrar Solicitud

</button>

</form>

</div>

</div>

</body>
</html>
