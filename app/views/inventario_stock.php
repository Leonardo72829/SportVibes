<nav class="migas"><a href="<?= url('inventario') ?>">Inventario</a> / Existencias</nav>

<div class="formulario-centrado">
  <p class="etiqueta">RF-04</p>
  <h1>Existencias de <?= e($producto['nombre']) ?></h1>

  <form method="post" action="<?= url('inventario/stock/' . (int) $producto['id']) ?>" class="formulario tarjeta-form">
    <?= csrf_field() ?>
    <?php foreach ($tallas as $talla): ?>
      <label for="stock_<?= (int) $talla['id'] ?>">Talla <?= e($talla['etiqueta']) ?></label>
      <input id="stock_<?= (int) $talla['id'] ?>" type="number" name="stock_<?= (int) $talla['id'] ?>" min="0" max="9999" value="<?= (int) $talla['existencias'] ?>" required>
    <?php endforeach; ?>
    <button class="boton" type="submit">Actualizar existencias</button>
  </form>
</div>
