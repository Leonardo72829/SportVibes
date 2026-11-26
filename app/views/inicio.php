<section class="hero">
  <div class="hero__contenido">
    <p class="etiqueta">Fútbol · Kings League · Esports</p>
    <h1>Tu equipo, <span>tu estilo</span>, tu jersey.</h1>
    <p class="hero__texto">Elige tu liga favorita, personaliza nombre y dorsal y recibe tu prenda en casa. Sin filas, sin complicaciones.</p>
    <div class="hero__acciones">
      <a class="boton" href="<?= url('catalogo') ?>">Ver catálogo</a>
      <a class="boton boton--secundario" href="<?= url('registro') ?>">Crear mi cuenta</a>
    </div>
  </div>
  <div class="hero__visual" aria-hidden="true">
    <div class="jersey"><span>SV</span></div>
  </div>
</section>

<section class="seccion">
  <div class="seccion__cabecera">
    <div>
      <p class="etiqueta">Explora</p>
      <h2>Compra por liga</h2>
    </div>
    <a class="enlace" href="<?= url('catalogo') ?>">Ver todo →</a>
  </div>
  <div class="cuadricula cuadricula--ligas">
    <?php foreach ($ligas as $liga): ?>
      <a class="tarjeta-liga" href="<?= url('catalogo?liga=' . (int) $liga['id']) ?>">
        <span class="tarjeta-liga__icono" aria-hidden="true"><?= e(mb_substr($liga['nombre'], 0, 1)) ?></span>
        <span><?= e($liga['nombre']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="seccion">
  <div class="seccion__cabecera">
    <div>
      <p class="etiqueta">Lo más buscado</p>
      <h2>Destacados</h2>
    </div>
  </div>
  <div class="cuadricula">
    <?php foreach ($destacados as $producto): ?>
      <article class="tarjeta">
        <div class="tarjeta__imagen"><?= imagen_producto($producto) ?></div>
        <div class="tarjeta__cuerpo">
          <p class="tarjeta__liga"><?= e($producto['liga']) ?></p>
          <h3><?= e($producto['nombre']) ?></h3>
          <p class="precio"><?= dinero((float) $producto['precio']) ?></p>
          <a class="boton boton--pequeno" href="<?= url('producto/' . (int) $producto['id']) ?>">Ver detalle</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="seccion bloque-info">
  <div>
    <p class="etiqueta">Cómo funciona</p>
    <h2>De tu liga a tu puerta en 3 pasos</h2>
  </div>
  <ol class="pasos">
    <li><strong>1. Elige</strong><span>Selecciona tu liga, prenda y talla.</span></li>
    <li><strong>2. Personaliza</strong><span>Agrega nombre y dorsal (hasta 12 caracteres).</span></li>
    <li><strong>3. Recibe</strong><span>Paga en línea y sigue tu pedido con número de guía.</span></li>
  </ol>
</section>
