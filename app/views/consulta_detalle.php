<nav class="migas"><a href="<?= url('consultas') ?>">Mis consultas</a> / <?= e($consulta['folio']) ?></nav>

<section class="tarjeta-form">
  <p class="etiqueta">Consulta · <?= e(fecha($consulta['fecha'])) ?></p>
  <h1><?= e($consulta['folio']) ?></h1>
  <p><?= nl2br(e($consulta['mensaje'])) ?></p>
</section>

<h2>Respuestas</h2>
<?php if ($respuestas === []): ?>
  <div class="aviso aviso--info">Tu consulta está en espera. Te avisaremos por correo cuando haya respuesta.</div>
<?php else: ?>
  <div class="lista-tarjetas">
    <?php foreach ($respuestas as $respuesta): ?>
      <article class="tarjeta-form">
        <p class="etiqueta"><?= e($respuesta['autor']) ?> · <?= e(fecha($respuesta['fecha'])) ?></p>
        <p><?= nl2br(e($respuesta['mensaje'])) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
