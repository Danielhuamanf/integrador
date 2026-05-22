
@include('layouts.header')

<style>

.main{
    flex:1;
    padding:30px;
    background:#f4f6fa;
    min-height:100vh;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topbar h1{
    color:#6c3ce9;
    font-size:30px;
    margin:0;
}

.subtitle{
    color:#777;
    margin-top:5px;
    font-size:14px;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
}

.menu-card{
    background:#fff;
    border-radius:18px;
    padding:28px 24px;
    text-decoration:none;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
    transition:.25s;
    position:relative;
    overflow:hidden;
}

.menu-card:hover{
    transform:translateY(-6px);
    box-shadow:0 10px 25px rgba(108,60,233,.15);
}

.menu-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:#6c3ce9;
}

.menu-icon{
    width:65px;
    height:65px;
    border-radius:16px;
    background:#f3efff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:20px;
}

.menu-icon i{
    font-size:28px;
    color:#6c3ce9;
}

.menu-title{
    font-size:18px;
    font-weight:700;
    color:#333;
    margin-bottom:8px;
}

.menu-desc{
    color:#777;
    font-size:14px;
    line-height:1.5;
}

.active-card{
    border:2px solid #6c3ce9;
}

@media(max-width:768px){

    .main{
        padding:20px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
    }

}

</style>

<div class="main">

    <div class="topbar">

        <div>

            <h1>Panel Administrativo</h1>

            <div class="subtitle">
                Gestión integral del sistema logístico
            </div>

        </div>

    </div>

    <div class="menu-grid">

        {{-- HOME --}}
        <a href="{{ url('/home_admin') }}"
        class="menu-card {{ $data['url'] == 'home' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-house"></i>
            </div>

            <div class="menu-title">
                Home
            </div>

            <div class="menu-desc">
                Acceso rápido al inicio del sistema.
            </div>

        </a>

        {{-- DASHBOARD --}}
        <a href="{{ url('/home_admin') }}"
        class="menu-card {{ $data['url'] == 'dashboard' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-chart-line"></i>
            </div>

            <div class="menu-title">
                Dashboard
            </div>

            <div class="menu-desc">
                Visualización de métricas y reportes.
            </div>

        </a>

        {{-- ENVIOS --}}
        <a href="{{ url('ver_ventas') }}"
        class="menu-card {{ $data['url'] == 'ventas' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-chart-pie"></i>
            </div>

            <div class="menu-title">
                Envíos
            </div>

            <div class="menu-desc">
                Registro y seguimiento de operaciones logísticas.
            </div>

        </a>

        {{-- DOCUMENTOS --}}
        <a href="{{ url('documentos') }}"
        class="menu-card {{ $data['url'] == 'documentos' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-file"></i>
            </div>

            <div class="menu-title">
                Documentos
            </div>

            <div class="menu-desc">
                Gestión documental y vouchers.
            </div>

        </a>

        {{-- ALMACEN --}}
        <a href="{{ url('/almacen') }}"
        class="menu-card {{ $data['url'] == 'almacen' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-cubes"></i>
            </div>

            <div class="menu-title">
                Almacén
            </div>

            <div class="menu-desc">
                Control de almacenes y ubicaciones.
            </div>

        </a>

        {{-- ZONAS --}}
        <a href="{{ url('/zonas') }}"
        class="menu-card {{ $data['url'] == 'zonas' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-globe"></i>
            </div>

            <div class="menu-title">
                Zonas
            </div>

            <div class="menu-desc">
                Administración de zonas logísticas.
            </div>

        </a>

        {{-- PRECIOS --}}
        <a href="{{ url('/precios') }}"
        class="menu-card {{ $data['url'] == 'precios' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-money-bill-wave"></i>
            </div>

            <div class="menu-title">
                Tarifas y Precios
            </div>

            <div class="menu-desc">
                Configuración de costos y tarifas.
            </div>

        </a>

        {{-- CLIENTES --}}
        <a href="{{ url('/ver_clientes') }}"
        class="menu-card {{ $data['url'] == 'clientes' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-user-circle"></i>
            </div>

            <div class="menu-title">
                Clientes
            </div>

            <div class="menu-desc">
                Administración de clientes registrados.
            </div>

        </a>

        {{-- USUARIOS --}}
        <a href="{{ url('/ver_usuarios') }}"
        class="menu-card {{ $data['url'] == 'usuarios' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-users"></i>
            </div>

            <div class="menu-title">
                Usuarios
            </div>

            <div class="menu-desc">
                Gestión de accesos y usuarios del sistema.
            </div>

        </a>

        {{-- LEADS --}}
        <a href="{{ url('/ver_leads') }}"
        class="menu-card {{ $data['url'] == 'leads' ? 'active-card' : '' }}">

            <div class="menu-icon">
                <i class="fa fa-user-plus"></i>
            </div>

            <div class="menu-title">
                Leads
            </div>

            <div class="menu-desc">
                Seguimiento de prospectos y oportunidades.
            </div>

        </a>

    </div>

</div>

</body>