<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SportVibes: ropa deportiva y personalizada de fútbol y Esports. Elige tu liga, tu talla y tu dorsal.">
  <title><?= htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8') ?> — Ropa deportiva y Esports</title>
  <link rel="stylesheet" href="/css/estilos.css">
  <script src="/js/app.js" defer></script>
</head>
<body>
  <header class="cabecera">
    <div class="contenedor cabecera__interior">
      <a class="marca" href="/" aria-label="Ir al inicio de SportVibes">
        <span class="marca__icono" aria-hidden="true">SV</span>
        <span class="marca__texto">Sport<span>Vibes</span></span>
      </a>

      <button class="menu-boton" id="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="nav-principal">
        <span></span><span></span><span></span>
      </button>

      <nav class="navegacion" id="nav-principal" aria-label="Navegación principal">
        <a href="#catalogo">Catálogo</a>
        <a href="#como-funciona">Cómo funciona</a>
        <a href="#esports">Esports</a>
        <a class="navegacion__cta" href="#catalogo">Comprar ahora</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="contenedor hero__interior">
        <p class="hero__etiqueta">Fútbol · Esports · Personalizado</p>
        <h1 class="hero__titulo">Tu equipo.<br>Tu estilo.<br><span>Tu juego.</span></h1>
        <p class="hero__texto">Encuentra tu jersey favorito de las principales ligas, elige tu talla y personaliza tu nombre y dorsal. Todo desde un solo lugar y directo a tu puerta.</p>
        <div class="hero__acciones">
          <a class="boton boton--primario" href="#catalogo">Explorar catálogo</a>
          <a class="boton boton--secundario" href="#como-funciona">Cómo funciona</a>
        </div>
        <p class="hero__nota">Envíos dentro de México · Pago en línea seguro</p>
      </div>
    </section>

    <section class="seccion" id="catalogo">
      <div class="contenedor">
        <p class="seccion__etiqueta">Catálogo</p>
        <h2 class="seccion__titulo">Elige tu liga</h2>
        <p class="seccion__intro">Jerseys oficiales y personalizados de las competencias que más te apasionan.</p>

        <div class="tarjetas">
          <article class="tarjeta"><span class="tarjeta__escudo">LMX</span><h3>Liga MX</h3><p>Los clubes de casa.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">PL</span><h3>Premier League</h3><p>La liga más vista.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">BL</span><h3>Bundesliga</h3><p>Fútbol a toda velocidad.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">L1</span><h3>Ligue 1</h3><p>Estilo y técnica.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">SA</span><h3>Serie A</h3><p>La pasión italiana.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">BRA</span><h3>Brasil A</h3><p>El fútbol de alegría.</p></article>
          <article class="tarjeta"><span class="tarjeta__escudo">KL</span><h3>Kings League</h3><p>Un nuevo formato.</p></article>
          <article class="tarjeta tarjeta--esports" id="esports"><span class="tarjeta__escudo">ES</span><h3>Esports</h3><p>Tu equipo digital.</p></article>
        </div>
      </div>
    </section>

    <section class="seccion seccion--alterna" id="como-funciona">
      <div class="contenedor">
        <p class="seccion__etiqueta">Simple y rápido</p>
        <h2 class="seccion__titulo">Así funciona SportVibes</h2>

        <ol class="pasos">
          <li class="paso"><span class="paso__numero">1</span><h3>Elige</h3><p>Explora el catálogo por liga, selecciona tu prenda y tu talla.</p></li>
          <li class="paso"><span class="paso__numero">2</span><h3>Personaliza</h3><p>Agrega tu nombre y dorsal a las prendas que lo permiten.</p></li>
          <li class="paso"><span class="paso__numero">3</span><h3>Recibe</h3><p>Paga en línea, sigue tu pedido y recibe el número de guía por correo.</p></li>
        </ol>
      </div>
    </section>

    <section class="llamada">
      <div class="contenedor llamada__interior">
        <h2>Viste tu pasión. Lleva tu vibes a la cancha.</h2>
        <a class="boton boton--primario" href="#catalogo">Ver todas las prendas</a>
      </div>
    </section>
  </main>

  <footer class="pie">
    <div class="contenedor pie__interior">
      <p>&copy; <span id="anio">2026</span> <?= htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8') ?>. Todos los derechos reservados.</p>
      <p>Hecho para los que viven el deporte.</p>
    </div>
  </footer>
</body>
</html>
