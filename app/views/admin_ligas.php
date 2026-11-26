<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-23</p>
    <h1>Ligas</h1>
  </div>
</div>

<div class="checkout">
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>ID</th><th>Nombre</th><th>Activa</th></tr></thead>
      <tbody>
        <?php foreach ($ligas as $liga): ?>
          <tr>
            <td><?= (int) $liga['id'] ?></td>
            <td><strong><?= e($liga['nombre']) ?></strong></td>
            <td><?= (int) $liga['activa'] === 1 ? 'Sí' : 'No' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <section class="tarjeta-form">
    <h2>Nueva liga</h2>
    <form method="post" action="<?= url('admin/ligas') ?>" class="formulario">
      <?= csrf_field() ?>
      <label for="nombre">Nombre</label>
      <input id="nombre" name="nombre" required maxlength="80">
      <label class="opcion"><input type="checkbox" name="activa" value="1" checked> Activa en el catálogo</label>
      <button class="boton" type="submit">Agregar liga</button>
    </form>
  </section>
</div>
