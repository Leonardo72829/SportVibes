<div class="formulario-centrado">
  <p class="etiqueta">Bienvenido de nuevo</p>
  <h1>Iniciar sesión</h1>

  <form method="post" action="<?= url('login') ?>" class="formulario tarjeta-form">
    <?= csrf_field() ?>
    <label for="correo">Correo electrónico</label>
    <input id="correo" type="email" name="correo" value="<?= old('correo') ?>" required autocomplete="email">

    <label for="clave">Contraseña</label>
    <input id="clave" type="password" name="clave" required autocomplete="current-password">

    <button class="boton" type="submit">Entrar</button>
  </form>

  <p class="texto-suave">¿No tienes cuenta? <a class="enlace" href="<?= url('registro') ?>">Crea una aquí</a>.</p>

  <details class="ayuda">
    <summary>Cuentas de demostración</summary>
    <ul>
      <li>Cliente: <code>cliente@sportvibes.test</code> / <code>Cliente123!</code></li>
      <li>Administrador: <code>admin@sportvibes.test</code> / <code>Admin123!</code></li>
      <li>Inventario: <code>inventario@sportvibes.test</code> / <code>Inventario123!</code></li>
      <li>Logística: <code>logistica@sportvibes.test</code> / <code>Logistica123!</code></li>
      <li>Soporte: <code>soporte@sportvibes.test</code> / <code>Soporte123!</code></li>
    </ul>
  </details>
</div>
