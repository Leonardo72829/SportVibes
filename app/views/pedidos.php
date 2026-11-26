<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Historial</p>
    <h1>Mis pedidos</h1>
  </div>
  <a class="enlace" href="<?= url('consultas') ?>">¿Necesitas ayuda? Envía una consulta →</a>
</div>

<?php if ($pedidos === []): ?>
  <div class="aviso aviso--info">Aún no tienes pedidos. <a class="enlace" href="<?= url('catalogo') ?>">Explora el catálogo</a>.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead>
        <tr><th>Pedido</th><th>Fecha</th><th>Estado</th><th>Guía</th><th>Total</th><th>&nbsp;</th></tr>
      </thead>
      <tbody>
        <?php foreach ($pedidos as $pedido): ?>
          <tr>
            <td><strong><?= e($pedido['numero_pedido']) ?></strong></td>
            <td><?= e(fecha($pedido['fecha_pedido'])) ?></td>
            <td><?= estadoBadge($pedido['estado']) ?></td>
            <td><?= $pedido['numero_guia'] !== null ? e($pedido['numero_guia']) : '—' ?></td>
            <td><?= dinero((float) $pedido['total']) ?></td>
            <td><a class="enlace" href="<?= url('pedidos/' . (int) $pedido['id']) ?>">Ver detalle</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
