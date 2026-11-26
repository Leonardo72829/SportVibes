<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-23</p>
    <h1>Categorías</h1>
  </div>
</div>

<div class="checkout">
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>ID</th><th>Nombre</th><th>Liga</th></tr></thead>
      <tbody>
        <?php foreach ($categorias as $categoria): ?>
          <tr>
            <td><?= (int) $categoria['id'] ?></td>
            <td><strong><?= e($categoria['nombre']) ?></strong></td>
            <td><?= e($categoria['liga'] ?? '—') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <section class="tarjeta-form">
    <h2>Nueva categoría</h2>
    <form method="post" action="<?= url('admin/categorias') ?>" class="formulario">
      <?= csrf_field() ?>
      <label for="nombre">Nombre</label>
      <input id="nombre" name="nombre" required maxlength="80">
      <label for="liga_id">Liga</label>
      <select id="liga_id" name="liga_id" required>
        <?php foreach ($ligas as $liga): ?>
          <option value="<?= (int) $liga['id'] ?>"><?= e($liga['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="boton" type="submit">Agregar categoría</button>
    </form>
  </section>
</div>
