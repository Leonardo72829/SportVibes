<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Ayuda</p>
    <h1>Mis consultas</h1>
  </div>
</div>

<div class="checkout">
  <section class="tarjeta-form">
    <h2>Enviar una consulta</h2>
    <form method="post" action="<?= url('consultas') ?>" class="formulario">
      <?= csrf_field() ?>
      <label for="pedido_id">Pedido relacionado (opcional)</label>
      <select id="pedido_id" name="pedido_id">
        <option value="">Ninguno</option>
        <?php foreach (Database::todos('SELECT id, numero_pedido FROM pedidos WHERE usuario_id = ? ORDER BY id DESC', [(int) Auth::id()]) as $pedido): ?>
          <option value="<?= (int) $pedido['id'] ?>"><?= e($pedido['numero_pedido']) ?></option>
        <?php endforeach; ?>
      </select>
      <label for="mensaje">¿En qué podemos ayudarte?</label>
      <textarea id="mensaje" name="mensaje" rows="5" minlength="10" maxlength="2000" required></textarea>
      <button class="boton" type="submit">Enviar consulta</button>
    </form>
  </section>

  <div>
    <?php if ($consultas === []): ?>
      <div class="aviso aviso--info">Aún no has enviado consultas.</div>
    <?php else: ?>
      <div class="tabla-contenedor">
        <table class="tabla">
          <thead><tr><th>Folio</th><th>Fecha</th><th>Estado</th><th>&nbsp;</th></tr></thead>
          <tbody>
            <?php foreach ($consultas as $consulta): ?>
              <tr>
                <td><strong><?= e($consulta['folio']) ?></strong></td>
                <td><?= e(fecha($consulta['fecha'])) ?></td>
                <td><?= (int) $consulta['atendida'] === 1 ? 'Respondida' : 'En espera' ?></td>
                <td><a class="enlace" href="<?= url('consultas/' . (int) $consulta['id']) ?>">Ver</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
