<div class="seccion__cabecera">
  <div>
    <p class="etiqueta">RF-24</p>
    <h1>Cuentas del personal</h1>
  </div>
</div>

<div class="checkout">
  <div class="tabla-contenedor">
    <table class="tabla">
      <thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th>&nbsp;</th></tr></thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><strong><?= e($usuario['nombre']) ?></strong></td>
            <td><?= e($usuario['correo']) ?></td>
            <td><?= e($usuario['rol']) ?></td>
            <td><?= (int) $usuario['activo'] === 1 ? 'Activo' : 'Desactivado' ?></td>
            <td>
              <form method="post" action="<?= url('admin/usuarios/' . (int) $usuario['id'] . '/estado') ?>" class="formulario-inline">
                <?= csrf_field() ?>
                <button class="boton boton--pequeno boton--claro" type="submit">
                  <?= (int) $usuario['activo'] === 1 ? 'Desactivar' : 'Activar' ?>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <section class="tarjeta-form">
    <h2>Nueva cuenta</h2>
    <form method="post" action="<?= url('admin/usuarios') ?>" class="formulario">
      <?= csrf_field() ?>
      <label for="nombre">Nombre</label>
      <input id="nombre" name="nombre" required maxlength="100">
      <label for="correo">Correo</label>
      <input id="correo" type="email" name="correo" required>
      <label for="rol_id">Rol</label>
      <select id="rol_id" name="rol_id" required>
        <?php foreach ($roles as $rol): ?>
          <option value="<?= (int) $rol['id'] ?>"><?= e($rol['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
      <label for="clave">Contraseña (mínimo 8 caracteres)</label>
      <input id="clave" type="password" name="clave" minlength="8" required>
      <button class="boton" type="submit">Crear cuenta</button>
    </form>
  </section>
</div>
