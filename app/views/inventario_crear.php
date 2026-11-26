<nav class="migas"><a href="<?= url('inventario') ?>">Inventario</a> / Registrar artículo</nav>

<div class="formulario-centrado">
  <p class="etiqueta">RF-03</p>
  <h1>Registrar artículo</h1>

  <form method="post" action="<?= url('inventario') ?>" class="formulario tarjeta-form">
    <?= csrf_field() ?>
    <label for="codigo_barras">Código de barras</label>
    <input id="codigo_barras" name="codigo_barras" required maxlength="64" value="<?= old('codigo_barras') ?>">

    <label for="nombre">Nombre</label>
    <input id="nombre" name="nombre" required maxlength="150" value="<?= old('nombre') ?>">

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" maxlength="1000"><?= old('descripcion') ?></textarea>

    <div class="formulario__fila">
      <div>
        <label for="precio">Precio</label>
        <input id="precio" type="number" step="0.01" min="1" name="precio" required value="<?= old('precio') ?>">
      </div>
      <div>
        <label for="costo">Costo</label>
        <input id="costo" type="number" step="0.01" min="0" name="costo" value="<?= old('costo', '0') ?>">
      </div>
    </div>

    <label for="liga_id">Liga</label>
    <select id="liga_id" name="liga_id" required>
      <?php foreach ($ligas as $liga): ?>
        <option value="<?= (int) $liga['id'] ?>"><?= e($liga['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <label for="categoria_id">Categoría</label>
    <select id="categoria_id" name="categoria_id" required>
      <?php foreach ($categorias as $categoria): ?>
        <option value="<?= (int) $categoria['id'] ?>"><?= e($categoria['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <fieldset>
      <legend>Existencias iniciales</legend>
      <div class="formulario__fila">
        <?php foreach ($tallas as $talla): ?>
          <div>
            <label for="stock_<?= (int) $talla['id'] ?>"><?= e($talla['etiqueta']) ?></label>
            <input id="stock_<?= (int) $talla['id'] ?>" type="number" name="stock_<?= (int) $talla['id'] ?>" min="0" value="0">
          </div>
        <?php endforeach; ?>
      </div>
    </fieldset>

    <label class="opcion"><input type="checkbox" name="personalizable" value="1"> Permite nombre y dorsal</label>

    <button class="boton" type="submit">Guardar artículo</button>
  </form>
</div>
