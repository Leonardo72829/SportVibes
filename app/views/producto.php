<nav class="migas"><a href="<?= url('catalogo') ?>">Catálogo</a> / <?= e($producto['nombre']) ?></nav>

<div class="detalle-producto">
  <div class="detalle-producto__visual">
    <?= imagen_producto($producto) ?>
  </div>

  <div class="detalle-producto__info">
    <p class="etiqueta"><?= e($producto['liga']) ?> · <?= e($producto['categoria']) ?></p>
    <h1><?= e($producto['nombre']) ?></h1>
    <p class="texto-suave"><?= e($producto['descripcion']) ?></p>
    <p class="precio precio--grande"><?= dinero((float) $producto['precio']) ?></p>

    <form method="post" action="<?= url('carrito/agregar') ?>" class="formulario">
      <?= csrf_field() ?>
      <input type="hidden" name="producto_id" value="<?= (int) $producto['id'] ?>">

      <label for="talla_id">Talla</label>
      <select id="talla_id" name="talla_id" required>
        <?php foreach ($tallas as $talla): ?>
          <?php $disponible = (int) $talla['existencias'] > 0; ?>
          <option value="<?= (int) $talla['id'] ?>" <?= !$disponible ? 'disabled' : '' ?>>
            <?= e($talla['etiqueta']) ?><?= $disponible ? '' : ' — Agotada' ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="cantidad">Cantidad</label>
      <input id="cantidad" type="number" name="cantidad" value="1" min="1" max="20" required>

      <?php if ((int) $producto['personalizable'] === 1): ?>
        <fieldset class="personalizacion">
          <legend>Personaliza tu jersey</legend>
          <label for="nombre_personalizado">Nombre (máx. 12 caracteres, sin palabras ofensivas)</label>
          <input id="nombre_personalizado" name="nombre_personalizado" maxlength="12" placeholder="Ej. LEO">
          <label for="dorsal">Dorsal (máx. 2 dígitos)</label>
          <input id="dorsal" type="number" name="dorsal" min="0" max="99" placeholder="Ej. 10">
        </fieldset>
      <?php endif; ?>

      <button class="boton" type="submit">Agregar al carrito</button>
    </form>
  </div>
</div>
