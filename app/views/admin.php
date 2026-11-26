<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-15</p>
    <h1>Reporte mensual</h1>
  </div>
  <form method="get" action="<?= url('admin') ?>" class="formulario-inline">
    <label for="mes">Mes</label>
    <input id="mes" type="month" name="mes" value="<?= e($mes) ?>">
    <button class="boton boton--pequeno" type="submit">Consultar</button>
  </form>
</div>

<div class="metricas">
  <div class="metrica"><span>Pedidos</span><strong><?= (int) $ventas['pedidos'] ?></strong></div>
  <div class="metrica"><span>Ingresos</span><strong><?= dinero((float) $ventas['ingresos']) ?></strong></div>
  <div class="metrica"><span>Envíos cobrados</span><strong><?= dinero((float) $ventas['envios']) ?></strong></div>
  <div class="metrica"><span>Utilidad estimada</span><strong><?= dinero((float) $utilidad['utilidad']) ?></strong></div>
</div>

<h2>Ventas por liga</h2>
<?php if ($porLiga === []): ?>
  <div class="aviso aviso--info">No hay ventas registradas en <?= e($mes) ?>.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>Liga</th><th>Unidades</th><th>Ingresos</th></tr></thead>
      <tbody>
        <?php foreach ($porLiga as $fila): ?>
          <tr>
            <td><?= e($fila['liga'] ?? 'Sin liga') ?></td>
            <td><?= (int) $fila['unidades'] ?></td>
            <td><?= dinero((float) $fila['ingresos']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<p class="texto-suave">La utilidad se calcula con el precio de venta menos el costo de cada prenda, sin incluir gastos operativos.</p>
