<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-21 y RF-22</p>
    <h1>Soporte</h1>
  </div>
</div>

<?php if ($consultas === []): ?>
  <div class="aviso aviso--info">No hay consultas pendientes.</div>
<?php else: ?>
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>Folio</th><th>Cliente</th><th>Fecha</th><th>Mensaje</th><th>Estado</th><th>&nbsp;</th></tr></thead>
      <tbody>
        <?php foreach ($consultas as $consulta): ?>
          <tr>
            <td><strong><?= e($consulta['folio']) ?></strong></td>
            <td><?= e($consulta['cliente']) ?></td>
            <td><?= e(fecha($consulta['fecha'])) ?></td>
            <td><?= e(mb_substr($consulta['mensaje'], 0, 80)) ?></td>
            <td><?= (int) $consulta['atendida'] === 1 ? 'Respondida' : 'En espera' ?></td>
            <td><a class="enlace" href="<?= url('soporte/' . (int) $consulta['id']) ?>">Atender</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
