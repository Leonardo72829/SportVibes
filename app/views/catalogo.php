<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">Tienda</p>
    <h1>Catálogo</h1>
    <p class="texto-suave">Encuentra la prenda de tu liga favorita y hazla tuya.</p>
  </div>
</div>

<div class="filtros">
  <form method="get" action="<?= url('catalogo') ?>" class="filtros__form">
    <label for="liga">Liga</label>
    <select id="liga" name="liga">
      <option value="">Todas las ligas</option>
      <?php foreach ($ligas as $liga): ?>
        <option value="<?= (int) $liga['id'] ?>" <?= $liga_activa === (int) $liga['id'] ? 'selected' : '' ?>>
          <?= e($liga['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label for="q">Buscar</label>
    <input id="q" type="search" name="q" value="<?= e($busqueda) ?>" placeholder="Ej. América, Esports">

    <button class="boton boton--pequeno" type="submit">Filtrar</button>
    <a class="enlace" href="<?= url('catalogo') ?>">Limpiar</a>
  </form>
</div>

<?php if ($productos === []): ?>
  <div class="aviso aviso--info">No hay productos con esos filtros. Prueba con otra liga o búsqueda.</div>
<?php else: ?>
  <div class="cuadricula">
    <?php foreach ($productos as $producto): ?>
      <article class="tarjeta">
        <div class="tarjeta__imagen"><?= imagen_producto($producto) ?></div>
        <div class="tarjeta__cuerpo">
          <p class="tarjeta__liga"><?= e($producto['liga']) ?></p>
          <h3><?= e($producto['nombre']) ?></h3>
          <p class="tarjeta__descripcion"><?= e(mb_substr((string) $producto['descripcion'], 0, 90)) ?></p>
          <p class="precio"><?= dinero((float) $producto['precio']) ?></p>
          <p class="texto-suave"><?= (int) $producto['stock'] > 0 ? (int) $producto['stock'] . ' disponibles' : 'Agotado' ?></p>
          <a class="boton boton--pequeno" href="<?= url('producto/' . (int) $producto['id']) ?>">Ver detalle</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
