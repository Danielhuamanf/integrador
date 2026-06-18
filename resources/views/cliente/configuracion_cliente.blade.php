{{-- resources/views/cliente/configuracion.blade.php --}}

@include('layouts.header_cliente')

<style>

.main{
    background-image:
    linear-gradient(
        rgba(255,255,255,.45),
        rgba(255,255,255,.45)
    ),
    url('{{ asset('assets/fondo1.webp') }}');

    background-size:cover;
    min-height:100vh;
    flex:1;
    padding:25px;
}

.topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}

.topbar h1{
    color:#4b2ad6;
    font-size:28px;
    margin:0;
}

.security-container{
    max-width:800px;
    margin:auto;
}

.security-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(6px);
    padding:35px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.security-card h2{
    margin-top:0;
    color:#333;
}

.subtitle{
    font-size:13px;
    color:#777;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:13px;
    font-weight:bold;
    color:#555;
}

.form-group input{
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #ddd;
    background:#fafafa;
    outline:none;
}

.form-group input:focus{
    border-color:#6c3ce9;
    background:#fff;
}

.rules-box{
    background:#f5f5f5;
    padding:18px;
    border-radius:10px;
    margin-top:20px;
    font-size:13px;
}

.rules-box h4{
    margin-top:0;
    margin-bottom:10px;
}

.rules-box ul{
    margin:0;
    padding-left:18px;
}

.rules-box li{
    margin-bottom:6px;
}

.btn-save{
    margin-top:25px;
    width:100%;
    padding:15px;
    background:#6c3ce9;
    color:#fff;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
}

.btn-save:hover{
    opacity:.92;
}

.alert-success{
    background:#eafaf1;
    color:#27ae60;
    padding:14px;
    border-radius:10px;
    margin-bottom:20px;
}

.alert-error{
    background:#ffeaea;
    color:#e74c3c;
    padding:14px;
    border-radius:10px;
    margin-bottom:20px;
}

.error-list{
    background:#fff0f0;
    color:#d63031;
    padding:14px;
    border-radius:10px;
    margin-bottom:20px;
}

@media(max-width:900px){

    .security-card{
        padding:25px;
    }

}
.form-group select{
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #ddd;
    background:#fafafa;
    outline:none;
}

.form-group select:focus{
    border-color:#6c3ce9;
    background:#fff;
}
</style>

<div class="main">

    <div class="topbar">

        <h1>
            Configuración Usuario
        </h1>

    </div>

    <div class="security-container">

        @if(session('success'))

            <div class="alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert-error">

                {{ session('error') }}

            </div>

        @endif

        @if ($errors->any())

            <div class="error-list">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('cliente.configuracion.update') }}"
            method="POST"
        >

            @csrf

            <div class="security-card">

                <h2>
                    Configuración de Cuenta
                </h2>

                <p class="subtitle">

                    Actualiza tus datos personales y seguridad.

                </p>
                <div class="form-group">

                    <label>
                        Tipo de Persona
                    </label>

                    <select
                        name="tipo_persona"
                        id="tipo_persona"
                    >
                        <option value="natural"
                            {{ old('tipo_persona', $cliente->tipo_persona) == 'natural' ? 'selected' : '' }}>
                            Persona Natural
                        </option>

                        <option value="empresa"
                            {{ old('tipo_persona', $cliente->tipo_persona) == 'empresa' ? 'selected' : '' }}>
                            Empresa
                        </option>
                    </select>

                </div>
                <div class="form-group">

                    <label>
                        Nombre Completo
                    </label>

                    <input
                        type="text"
                        name="nombre_completo"
                        value="{{ old('nombre_completo', $cliente->nombre_completo ?? '') }}"
                        placeholder="Nombre completo"
                    >

                </div>

                <div class="form-group">

                    <label>
                        DNI
                    </label>

                    <input
                        type="text"
                        name="dni"
                        value="{{ old('dni', $cliente->dni ?? '') }}"
                        placeholder="DNI"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Ubigeo
                    </label>

                    <input
                        type="text"
                        name="ubigeo"
                        value="{{ old('ubigeo', $cliente->ubigeo ?? '') }}"
                        placeholder="Ubigeo"
                    >

                </div>
                <div id="empresa-fields">
               
                
                <div class="form-group">

                    <label>
                        RUC
                    </label>

                    <input
                        type="text"
                        name="ruc"
                        value="{{ old('ruc', $cliente->ruc ?? '') }}"
                        placeholder="RUC"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Nombre Comercial
                    </label>

                    <input
                        type="text"
                        name="nombre_comercial"
                        value="{{ old('nombre_comercial', $cliente->nombre_comercial ?? '') }}"
                        placeholder="Nombre Comercial"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Representante Legal
                    </label>

                    <input
                        type="text"
                        name="representante_legal"
                        value="{{ old('representante_legal', $cliente->representante_legal ?? '') }}"
                        placeholder="Representante Legal"
                    >

                </div>
                
            
            </div>
                <div class="form-group">

                    <label>
                        Celular
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        value="{{ $cliente->telefono ?? '' }}"
                        placeholder="+51 999 999 999"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Dirección
                    </label>

                    <input
                        type="text"
                        name="direccion"
                        value="{{ $cliente->direccion ?? '' }}"
                        placeholder="Lugar de entrega"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Correo Electrónico
                    </label>

                    <input
                        type="email"
                        name="correo"
                        value="{{ $cliente->correo ?? $usuario->correo }}"
                        placeholder="Email"
                    >

                </div>

                <hr style="margin:30px 0;border:none;border-top:1px solid #eee;">

                <div class="form-group">

                    <label>
                        Contraseña Actual
                    </label>

                    <input
                        type="password"
                        name="password_actual"
                        placeholder="Contraseña actual"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Nueva Contraseña
                    </label>

                    <input
                        type="password"
                        name="password_nuevo"
                        placeholder="Nueva contraseña"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Confirmar Contraseña
                    </label>

                    <input
                        type="password"
                        name="password_confirmacion"
                        placeholder="Confirmar contraseña"
                    >

                </div>

                <div class="rules-box">

                    <h4>
                        Reglas de contraseña
                    </h4>

                    <ul>

                        <li>
                            Mínimo 8 caracteres
                        </li>

                        <li>
                            Al menos un número
                        </li>

                        <li>
                            No reutilizar contraseñas antiguas
                        </li>

                    </ul>

                </div>

                <button class="btn-save">

                    Guardar Cambios

                </button>

            </div>

        </form>

    </div>

</div>

</body>
<script>
function toggleEmpresa() {

    let tipo = document.getElementById('tipo_persona').value;

    document.getElementById('empresa-fields').style.display =
        tipo === 'empresa'
            ? 'block'
            : 'none';
}

document
    .getElementById('tipo_persona')
    .addEventListener('change', toggleEmpresa);

toggleEmpresa();
</script>
</html>