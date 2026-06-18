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

		<form method="POST" action="{{url('cliente/solicitudes')}}">

			@csrf
			<div class="group">

			    <label>Envío</label>

			    <select name="id_envio" required>

			        <option value="">
			            Seleccione
			        </option>

			        @foreach($envios as $envio)

			        <option value="{{ $envio->id_envio }}">

			            ENV-{{ $envio->id_envio }}
			            - {{ $envio->tipo_envio }}

			        </option>

			        @endforeach

			    </select>

			</div>
			<div class="group">

			    <label>Tipo de Solicitud</label>

			    <select name="tipo" id="tipo" required>

			        <option value="">Seleccione</option>

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
			<div id="campos_dinamicos"></div>
			<button  type="submit" class="btn btn-primary">Enviar</button>
		</form>

	</div>

</div>
<script>

const tipo = document.getElementById('tipo');
const contenedor = document.getElementById('campos_dinamicos');

function renderizarCampos()
{
    let html = '';

    switch(tipo.value)
    {
        case 'tracking':

            html = `
            <div class="group">
                <label>Número Tracking</label>
                <input type="text" name="numero_tracking">
            </div>

            <div class="group">
                <label>Consulta Tracking</label>
                <textarea name="descripcion_tracking"></textarea>
            </div>
            `;
        break;

        case 'estado_envio':

            html = `
            <div class="group">
                <label>Consulta Estado Envío</label>
                <textarea name="descripcion_estado_envio"></textarea>
            </div>
            `;
        break;

        case 'dam':

            html = `
            <div class="group">
                <label>Número DAM</label>
                <input type="text" name="numero_dam">
            </div>

            <div class="group">
                <label>Año DAM</label>
                <input type="text" name="anio_dam">
            </div>

            <div class="group">
                <label>Detalle Consulta DAM</label>
                <textarea name="descripcion_dam"></textarea>
            </div>
            `;
        break;

        case 'documentos':

            html = `
            <div class="group">
                <label>Documento Solicitado</label>

                <select name="tipo_documento">

                    <option value="DAM">
                        DAM
                    </option>

                    <option value="BL">
                        BL
                    </option>

                    <option value="FACTURA">
                        Factura Comercial
                    </option>

                    <option value="PACKING LIST">
                        Packing List
                    </option>

                    <option value="CERTIFICADO">
                        Certificado de Origen
                    </option>

                </select>

            </div>

            <div class="group">
                <label>Observación</label>
                <textarea name="descripcion_documento"></textarea>
            </div>
            `;
        break;
    }

    contenedor.innerHTML = html;
}

tipo.addEventListener('change', renderizarCampos);

</script>
</body>
</html>
