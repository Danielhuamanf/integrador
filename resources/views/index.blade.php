<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Empresa Transporte y Aduana</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f5f7fa;
    }

    header {
      position: relative;
      background: url('https://images.unsplash.com/photo-1581091215367-59ab6b1a8a3f') center/cover no-repeat;
      color: white;
      padding: 0;
    }

    .overlay {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                  url('https://images.unsplash.com/photo-1553413077-190dd305871c') center/cover no-repeat;
      padding: 20px;
    }

    .overlay-content {
      max-width: 700px;
    }

    .overlay-content h1 {
      font-size: 52px;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .overlay-content p {
      font-size: 20px;
      margin-bottom: 30px;
      color: #ddd;
    }

    .navbar {
      position: absolute;
      top: 0;
      width: 95%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      background: rgba(0,0,0,0.4);
    }

    .navbar h2 {
      margin: 0;
      font-weight: 600;
    }

    .nav-links a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-size: 14px;
      transition: 0.3s;
    }

    .nav-links a:hover {
      color: #ff9800;
    }

    .overlay h1 {
      font-size: 48px;
      margin-bottom: 15px;
    }

    .overlay p {
      font-size: 18px;
      margin-bottom: 25px;
    }

    header h1 {
      font-size: 42px;
      margin-bottom: 10px;
      background: rgba(0,0,0,0.5);
      display: inline-block;
      padding: 10px 20px;
      border-radius: 10px;
    }

    header p {
      font-size: 18px;
      margin-bottom: 20px;
      background: rgba(0,0,0,0.5);
      display: inline-block;
      padding: 5px 15px;
      border-radius: 8px;
    }

    .btn {
      background: #ff9800;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    .container {
      padding: 60px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .title {
      text-align: center;
      margin-bottom: 40px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .cta {
      background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') center/cover;
      color: white;
      text-align: center;
      padding: 80px 20px;
    }

    footer {
      background: #222;
      color: white;
      text-align: center;
      padding: 20px;
    }

    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>

<header>
  <div class="navbar">
    
    <h2><img src="assets/logo-pasoc.webp" width="120"></h2>
    <div class="nav-links">
      <a href="{{ route('login') }}">Login</a>

      <a href="#formulario" >Contacto</a>
    </div>
  </div>

  <div class="overlay">
    <div class="overlay-content">
      <h1>Soluciones Logísticas y Aduaneras</h1>
      <p>Transporte eficiente, gestión aduanera integral y cobertura internacional para tu negocio</p>
      <button class="btn" onclick="scrollToForm()">Solicitar Cotización</button>
    </div>
  </div>
</header>

<section class="container">
  <h2 class="title">Nuestros Servicios</h2>
  <div class="grid">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1601582589907-f92af5ed9db8" alt="Transporte">
      <h3>Transporte Nacional</h3>
      <p>Distribución en todo el país con monitoreo en tiempo real.</p>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1566576721346-d4a3b4eaeb55" alt="Internacional">
      <h3>Transporte Internacional</h3>
      <p>Gestión de carga marítima, aérea y terrestre.</p>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d" alt="Aduana">
      <h3>Gestión Aduanera</h3>
      <p>Trámites completos con cumplimiento normativo.</p>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1593642634367-d91a135587b5" alt="Seguridad">
      <h3>Seguridad de Carga</h3>
      <p>Protección y seguimiento constante de mercancías.</p>
    </div>
  </div>
</section>

<section class="container">
  <h2 class="title">¿Por qué elegirnos?</h2>
  <div class="grid">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d">
      <h3>Experiencia</h3>
      <p>Más de 10 años en logística y comercio exterior.</p>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1518770660439-4636190af475">
      <h3>Tecnología</h3>
      <p>Seguimiento en tiempo real.</p>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216">
      <h3>Atención Personalizada</h3>
      <p>Soporte directo para cada cliente.</p>
    </div>
  </div>
</section>

<section class="cta">
  <h2>Optimiza tu logística hoy</h2>
  <p>Contáctanos y lleva tu negocio al siguiente nivel</p>
</section>

<section class="container" id="formulario">
  <h2 class="title">Solicitar Cotización</h2>
  <form method="POST" action="{{ route('guardar_lead') }}">
        @csrf
    <input type="text" placeholder="Nombre" name="nombre" required>
    <input type="email" placeholder="Correo" name="correo" required>
    <input type="text" placeholder="Telefono" name="telefono" required>
    <textarea placeholder="Describe tu requerimiento" required  name="mensaje"></textarea>
    <button class="btn" type="submit">Enviar</button>
  </form>
</section>

<footer>
  <p>© 2026 Empresa de Transporte y Aduanas PASOC</p>
</footer>

<script>
  function scrollToForm() {
    document.getElementById("formulario").scrollIntoView({ behavior: "smooth" });
  }

  function enviarFormulario(e) {
    e.preventDefault();
    alert("Solicitud enviada correctamente");
  }
</script>

</body>
</html>
