<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Último paso</p>
    <h1>Finalizar compra</h1>
  </div>
  <a class="enlace" href="<?= url('carrito') ?>">← Volver al carrito</a>
</div>

<div class="checkout">
  <div>
    <section class="tarjeta-form">
      <h2>1. Dirección de entrega</h2>
      <?php if ($direcciones !== []): ?>
        <form method="post" action="<?= url('pedidos') ?>" class="formulario" data-confirmar="¿Confirmar el pedido con la dirección seleccionada?">
          <?= csrf_field() ?>
          <?php foreach ($direcciones as $direccion): ?>
            <label class="opcion">
              <input type="radio" name="direccion_id" value="<?= (int) $direccion['id'] ?>" required>
              <span>
                <strong><?= e($direccion['calle']) ?> <?= e($direccion['numero_ext'] ?? '') ?></strong><br>
                <?= e($direccion['colonia']) ?>, <?= e($direccion['codigo_postal']) ?> <?= e($direccion['ciudad']) ?>, <?= e($direccion['estado']) ?>
              </span>
            </label>
          <?php endforeach; ?>

          <label for="resultado">Resultado del pago simulado</label>
          <select id="resultado" name="resultado">
            <option value="aprobado">Aprobar pago (demo)</option>
            <option value="rechazado">Rechazar pago (demo)</option>
          </select>

          <button class="boton" type="submit">Confirmar y pagar</button>
        </form>
      <?php endif; ?>

      <details class="ayuda">
        <summary><?= $direcciones !== [] ? 'Usar una dirección nueva' : 'Captura tu dirección' ?></summary>
        <form method="post" action="<?= url('direcciones') ?>" class="formulario">
          <?= csrf_field() ?>
          <label for="calle">Calle</label>
          <input id="calle" name="calle" required maxlength="150">
          <label for="numero_ext">Número exterior</label>
          <input id="numero_ext" name="numero_ext" maxlength="20">
          <label for="colonia">Colonia</label>
          <input id="colonia" name="colonia" required maxlength="100">
          <label for="codigo_postal">Código postal</label>
          <input id="codigo_postal" name="codigo_postal" required inputmode="numeric" maxlength="5" pattern="\d{5}">
          <label for="ciudad">Ciudad</label>
          <input id="ciudad" name="ciudad" required maxlength="100">
          <label for="estado">Estado</label>
          <input id="estado" name="estado" required maxlength="100">
          <label for="referencia">Referencia (opcional)</label>
          <input id="referencia" name="referencia" maxlength="200">
          <button class="boton boton--claro" type="submit">Guardar dirección</button>
        </form>
      </details>
    </section>

    <?php if ($direcciones === []): ?>
      <div class="aviso aviso--info">Guarda una dirección para poder confirmar tu pedido.</div>
    <?php endif; ?>
  </div>

  <aside class="resumen">
    <h2>Tu pedido</h2>
    <ul class="resumen__lista">
      <?php foreach ($items as $item): ?>
        <li><?= e($item['cantidad']) ?> × <?= e($item['nombre']) ?> (<?= e($item['talla']) ?>)</li>
      <?php endforeach; ?>
    </ul>
    <p><span>Subtotal</span><strong><?= dinero($subtotal) ?></strong></p>
    <p><span>Envío</span><strong><?= dinero($envio) ?></strong></p>
    <p class="resumen__total"><span>Total</span><strong><?= dinero($total) ?></strong></p>
    <p class="texto-suave">Pago simulado: no se guardan datos de tarjeta (RNF-04).</p>
  </aside>
</div>
