<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Bandeja</p>
    <h1>Notificaciones</h1>
  </div>
</div>

<?php if ($notificaciones === []): ?>
  <div class="aviso aviso--info">No tienes notificaciones todavía.</div>
<?php else: ?>
  <div class="lista-tarjetas">
    <?php foreach ($notificaciones as $notificacion): ?>
      <article class="tarjeta-form <?= (int) $notificacion['leida'] === 0 ? 'tarjeta-form--nueva' : '' ?>">
        <p class="etiqueta"><?= e(str_replace('_', ' ', $notificacion['tipo'])) ?> · <?= e(fecha($notificacion['fecha'])) ?></p>
        <h2><?= e($notificacion['asunto']) ?></h2>
        <p><?= nl2br(e($notificacion['mensaje'])) ?></p>
        <?php if ((int) $notificacion['leida'] === 0): ?>
          <form method="post" action="<?= url('notificaciones/' . (int) $notificacion['id'] . '/leida') ?>">
            <?= csrf_field() ?>
            <button class="boton boton--pequeno boton--claro" type="submit">Marcar como leída</button>
          </form>
        <?php else: ?>
          <span class="texto-suave">Leída</span>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
