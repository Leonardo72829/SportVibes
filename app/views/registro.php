<div class="formulario-centrado">
  <p class="etiqueta">Únete a SportVibes</p>
  <h1>Crear cuenta</h1>

  <form method="post" action="<?= url('registro') ?>" class="formulario tarjeta-form">
    <?= csrf_field() ?>
    <label for="nombre">Nombre completo</label>
    <input id="nombre" type="text" name="nombre" value="<?= old('nombre') ?>" required maxlength="100" autocomplete="name">

    <label for="correo">Correo electrónico</label>
    <input id="correo" type="email" name="correo" value="<?= old('correo') ?>" required autocomplete="email">

    <label for="clave">Contraseña (mínimo 8 caracteres)</label>
    <input id="clave" type="password" name="clave" required minlength="8" autocomplete="new-password">

    <label for="confirmacion">Confirmar contraseña</label>
    <input id="confirmacion" type="password" name="confirmacion" required minlength="8" autocomplete="new-password">

    <button class="boton" type="submit">Crear mi cuenta</button>
  </form>

  <p class="texto-suave">¿Ya tienes cuenta? <a class="enlace" href="<?= url('login') ?>">Inicia sesión</a>.</p>
</div>
