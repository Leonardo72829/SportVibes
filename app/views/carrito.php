<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Tu selección</p>
    <h1>Mi carrito</h1>
  </div>
  <a class="enlace" href="<?= url('catalogo') ?>">Seguir comprando →</a>
</div>

<?php if ($items === []): ?>
  <div class="aviso aviso--info">Tu carrito está vacío. <a class="enlace" href="<?= url('catalogo') ?>">Explora el catálogo</a>.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead>
        <tr><th>Producto</th><th>Talla</th><th>Personalización</th><th>Cantidad</th><th>Subtotal</th><th>&nbsp;</th></tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <?php $subtotal = (float) $item['precio'] * (int) $item['cantidad']; ?>
          <tr>
            <td><strong><?= e($item['nombre']) ?></strong><br><span class="texto-suave"><?= dinero((float) $item['precio']) ?> c/u</span></td>
            <td><?= e($item['talla']) ?></td>
            <td>
              <?php if ($item['nombre_personalizado'] || $item['dorsal'] !== null): ?>
                <?= e($item['nombre_personalizado'] ?? '—') ?> · #<?= e($item['dorsal'] ?? '—') ?>
              <?php else: ?>
                <span class="texto-suave">Sin personalizar</span>
              <?php endif; ?>
            </td>
            <td>
              <form method="post" action="<?= url('carrito/actualizar') ?>" class="formulario-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="producto_id" value="<?= (int) $item['producto_id'] ?>">
                <input type="hidden" name="talla_id" value="<?= (int) $item['talla_id'] ?>">
                <input type="number" name="cantidad" value="<?= (int) $item['cantidad'] ?>" min="0" max="20" aria-label="Cantidad">
                <button class="boton boton--pequeno boton--claro" type="submit">Actualizar</button>
              </form>
            </td>
            <td><?= dinero($subtotal) ?></td>
            <td>
              <form method="post" action="<?= url('carrito/quitar') ?>" class="formulario-inline" data-confirmar="¿Quitar este artículo del carrito?">
                <?= csrf_field() ?>
                <input type="hidden" name="producto_id" value="<?= (int) $item['producto_id'] ?>">
                <input type="hidden" name="talla_id" value="<?= (int) $item['talla_id'] ?>">
                <button class="enlace-boton enlace-boton--peligro" type="submit">Quitar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <aside class="resumen">
    <h2>Resumen</h2>
    <p><span>Subtotal</span><strong><?= dinero($subtotal) ?></strong></p>
    <p><span>Envío (monto fijo dentro de México)</span><strong><?= dinero($envio) ?></strong></p>
    <p class="resumen__total"><span>Total</span><strong><?= dinero($total) ?></strong></p>
    <a class="boton" href="<?= url('checkout') ?>">Finalizar compra</a>
  </aside>
<?php endif; ?>
