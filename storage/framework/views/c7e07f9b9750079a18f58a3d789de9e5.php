

<?php echo $__env->make('layouts.header_cliente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>

.main{
    background-image:
    linear-gradient(
        rgba(255,255,255,.45),
        rgba(255,255,255,.45)
    ),
    url('<?php echo e(asset('assets/fondo1.webp')); ?>');

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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>

            <div class="alert-success">

                <?php echo e(session('success')); ?>


            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>

            <div class="alert-error">

                <?php echo e(session('error')); ?>


            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>

            <div class="error-list">

                <ul>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                        <li><?php echo e($error); ?></li>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </ul>

            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form
            action="<?php echo e(route('cliente.configuracion.update')); ?>"
            method="POST"
        >

            <?php echo csrf_field(); ?>

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
                            <?php echo e(old('tipo_persona', $cliente->tipo_persona) == 'natural' ? 'selected' : ''); ?>>
                            Persona Natural
                        </option>

                        <option value="empresa"
                            <?php echo e(old('tipo_persona', $cliente->tipo_persona) == 'empresa' ? 'selected' : ''); ?>>
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
                        value="<?php echo e(old('nombre_completo', $cliente->nombre_completo ?? '')); ?>"
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
                        value="<?php echo e(old('dni', $cliente->dni ?? '')); ?>"
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
                        value="<?php echo e(old('ubigeo', $cliente->ubigeo ?? '')); ?>"
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
                        value="<?php echo e(old('ruc', $cliente->ruc ?? '')); ?>"
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
                        value="<?php echo e(old('nombre_comercial', $cliente->nombre_comercial ?? '')); ?>"
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
                        value="<?php echo e(old('representante_legal', $cliente->representante_legal ?? '')); ?>"
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
                        value="<?php echo e($cliente->telefono ?? ''); ?>"
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
                        value="<?php echo e($cliente->direccion ?? ''); ?>"
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
                        value="<?php echo e($cliente->correo ?? $usuario->correo); ?>"
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
</html><?php /**PATH D:\xampp\htdocs\integrador\resources\views/cliente/configuracion_cliente.blade.php ENDPATH**/ ?>