<nav class="migas"><a href="<?= url('soporte') ?>">Soporte</a> / <?= e($consulta['folio']) ?></nav>

<section class="tarjeta-form">
  <p class="etiqueta"><?= e($consulta['cliente']) ?> · <?= e($consulta['correo']) ?></p>
  <h1><?= e($consulta['folio']) ?></h1>
  <?php if ($consulta['numero_pedido'] !== null): ?>
    <p><strong>Pedido:</strong> <?= e($consulta['numero_pedido']) ?></p>
  <?php endif; ?>
  <p><?= nl2br(e($consulta['mensaje'])) ?></p>
</section>

<h2>Respuestas previas</h2>
<?php if ($respuestas === []): ?>
  <div class="aviso aviso--info">Todavía no hay respuestas.</div>
<?php else: ?>
  <?php foreach ($respuestas as $respuesta): ?>
    <article class="tarjeta-form">
      <p class="etiqueta"><?= e($respuesta['autor']) ?> · <?= e(fecha($respuesta['fecha'])) ?></p>
      <p><?= nl2br(e($respuesta['mensaje'])) ?></p>
    </article>
  <?php endforeach; ?>
<?php endif; ?>

<h2>Nueva respuesta</h2>
<form method="post" action="<?= url('soporte/' . (int) $consulta['id'] . '/responder') ?>" class="formulario tarjeta-form">
  <?= csrf_field() ?>
  <label for="mensaje">Mensaje para el cliente</label>
  <textarea id="mensaje" name="mensaje" rows="5" minlength="5" maxlength="2000" required></textarea>
  <button class="boton" type="submit">Enviar respuesta por correo</button>
</form>
