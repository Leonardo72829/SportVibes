<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-03 y RF-04</p>
    <h1>Inventario</h1>
  </div>
  <a class="boton boton--pequeno" href="<?= url('inventario/crear') ?>">Registrar artículo</a>
</div>

<div class="tabla-contenedor">
  <table class="tabla">
    <thead>
      <tr><th>Código</th><th>Producto</th><th>Liga</th><th>Precio</th><th>Costo</th><th>Existencias</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $producto): ?>
        <tr>
          <td><?= e($producto['codigo_barras']) ?></td>
          <td><strong><?= e($producto['nombre']) ?></strong></td>
          <td><?= e($producto['liga'] ?? '—') ?></td>
          <td><?= dinero((float) $producto['precio']) ?></td>
          <td><?= dinero((float) $producto['costo']) ?></td>
          <td><?= (int) $producto['stock'] ?></td>
          <td><a class="enlace" href="<?= url('inventario/stock/' . (int) $producto['id']) ?>">Editar stock</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
