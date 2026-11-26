<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-12, RF-18 y RF-19</p>
    <h1>Logística</h1>
    <p class="texto-suave">Pedidos pagados listos para preparar y enviar.</p>
  </div>
</div>

<?php if ($pedidos === []): ?>
  <div class="aviso aviso--info">No hay pedidos pendientes de envío.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead>
        <tr><th>Pedido</th><th>Cliente</th><th>Artículos</th><th>Estado</th><th>Guía</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($pedidos as $pedido): ?>
          <tr>
            <td><strong><?= e($pedido['numero_pedido']) ?></strong><br><span class="texto-suave"><?= dinero((float) $pedido['total']) ?></span></td>
            <td><?= e($pedido['cliente']) ?></td>
            <td><?= (int) $pedido['articulos'] ?></td>
            <td><?= estadoBadge($pedido['estado']) ?></td>
            <td><?= $pedido['numero_guia'] !== null ? e($pedido['numero_guia']) : '—' ?></td>
            <td>
              <form method="post" action="<?= url('logistica/' . (int) $pedido['id'] . '/guia') ?>" class="formulario-inline">
                <?= csrf_field() ?>
                <input type="text" name="numero_guia" placeholder="Número de guía" maxlength="60" value="<?= e($pedido['numero_guia'] ?? '') ?>">
                <button class="boton boton--pequeno boton--claro" type="submit">Guardar guía</button>
              </form>
              <form method="post" action="<?= url('logistica/' . (int) $pedido['id'] . '/estado') ?>" class="formulario-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="numero_guia" value="<?= e($pedido['numero_guia'] ?? '') ?>">
                <select name="estado" aria-label="Nuevo estado">
                  <?php foreach ($estados as $estado): ?>
                    <option value="<?= e($estado) ?>" <?= $estado === $pedido['estado'] ? 'selected' : '' ?>>
                      <?= e(str_replace('_', ' ', $estado)) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <button class="boton boton--pequeno" type="submit">Cambiar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
