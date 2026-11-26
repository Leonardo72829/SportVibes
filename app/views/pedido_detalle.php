<nav class="migas"><a href="<?= url('pedidos') ?>">Mis pedidos</a> / <?= e($pedido['numero_pedido']) ?></nav>

<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Detalle del pedido</p>
    <h1><?= e($pedido['numero_pedido']) ?> <?= estadoBadge($pedido['estado']) ?></h1>
    <p class="texto-suave">Realizado el <?= e(fecha($pedido['fecha_pedido'])) ?></p>
  </div>
</div>

<div class="detalle-pedido">
  <section>
    <h2>Artículos</h2>
    <div class="tabla-contenedor">
      <table class="tabla">
        <thead><tr><th>Producto</th><th>Talla</th><th>Personalización</th><th>Cant.</th><th>Precio</th></tr></thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= e($item['nombre']) ?></td>
              <td><?= e($item['talla']) ?></td>
              <td>
                <?php if ($item['nombre_personalizado'] || $item['dorsal'] !== null): ?>
                  <?= e($item['nombre_personalizado'] ?? '—') ?> · #<?= e($item['dorsal'] ?? '—') ?>
                <?php else: ?>—<?php endif; ?>
              </td>
              <td><?= (int) $item['cantidad'] ?></td>
              <td><?= dinero((float) $item['precio_unitario'] * (int) $item['cantidad']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h2>Seguimiento</h2>
    <ol class="linea-tiempo">
      <?php foreach ($historial as $evento): ?>
        <li><strong><?= e(str_replace('_', ' ', $evento['estado'])) ?></strong> · <?= e(fecha($evento['fecha'])) ?></li>
      <?php endforeach; ?>
    </ol>
  </section>

  <aside class="resumen">
    <h2>Entrega y pago</h2>
    <p class="texto-suave">
      <?= e($pedido['calle']) ?> <?= e($pedido['numero_ext'] ?? '') ?><br>
      <?= e($pedido['colonia']) ?>, <?= e($pedido['codigo_postal']) ?> <?= e($pedido['ciudad']) ?>, <?= e($pedido['estado']) ?>
    </p>
    <?php if ($pedido['numero_guia'] !== null): ?>
      <p><span>Guía</span><strong><?= e($pedido['numero_guia']) ?></strong></p>
    <?php endif; ?>
    <p><span>Subtotal</span><strong><?= dinero((float) $pedido['subtotal']) ?></strong></p>
    <p><span>Envío</span><strong><?= dinero((float) $pedido['envio']) ?></strong></p>
    <p class="resumen__total"><span>Total</span><strong><?= dinero((float) $pedido['total']) ?></strong></p>
    <?php foreach ($pagos as $pago): ?>
      <p class="texto-suave">Pago <?= e($pago['estado']) ?> · Ref. <?= e($pago['referencia']) ?></p>
    <?php endforeach; ?>
    <a class="boton boton--claro" href="<?= url('consultas') ?>">Hacer una consulta</a>
  </aside>
</div>
