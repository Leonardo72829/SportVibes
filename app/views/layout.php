<?php
/** Plantilla base compartida por todas las vistas. */
$usuarioActual = Auth::usuario();
$rolActual = $usuarioActual['rol'] ?? null;
$mensajes = tomarFlashes();
$sinLeer = 0;
if ($usuarioActual !== null) {
    $fila = Database::uno('SELECT COUNT(*) AS n FROM notificaciones WHERE usuario_id = ? AND leida = 0', [(int) $usuarioActual['id']]);
    $sinLeer = (int) ($fila['n'] ?? 0);
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="SportVibes: ropa deportiva y personalizada de fútbol y Esports. Elige tu liga, tu talla y tu dorsal.">
  <title><?= e($titulo !== '' ? $titulo . ' | ' . APP_NAME : APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= url('css/estilos.css') ?>">
  <script src="<?= url('js/app.js') ?>" defer></script>
</head>
<body>
  <header class="cabecera">
    <div class="contenedor cabecera__interno">
      <a class="marca" href="<?= url() ?>" aria-label="Ir al inicio de SportVibes">
        <span class="marca__icono" aria-hidden="true">◆</span> Sport<span>Vibes</span>
      </a>

      <button class="menu-boton" type="button" aria-expanded="false" aria-controls="navegacion" data-menu-boton>
        <span></span><span></span><span></span>
        <span class="sr-only">Abrir menú</span>
      </button>

      <nav class="navegacion" id="navegacion" data-navegacion aria-label="Navegación principal">
        <a href="<?= url() ?>">Inicio</a>
        <a href="<?= url('catalogo') ?>">Catálogo</a>

        <?php if ($usuarioActual !== null): ?>
          <a href="<?= url('carrito') ?>">Carrito</a>
          <a href="<?= url('pedidos') ?>">Mis pedidos</a>
          <a href="<?= url('consultas') ?>">Consultas</a>
          <a href="<?= url('notificaciones') ?>">Avisos<?= $sinLeer > 0 ? ' <span class="contador">' . $sinLeer . '</span>' : '' ?></a>

          <?php if (in_array($rolActual, ['inventario', 'administrador'], true)): ?>
            <a href="<?= url('inventario') ?>">Inventario</a>
          <?php endif; ?>
          <?php if ($rolActual === 'logistica'): ?>
            <a href="<?= url('logistica') ?>">Logística</a>
          <?php endif; ?>
          <?php if ($rolActual === 'soporte'): ?>
            <a href="<?= url('soporte') ?>">Soporte</a>
          <?php endif; ?>
          <?php if ($rolActual === 'administrador'): ?>
            <a href="<?= url('admin') ?>">Reportes</a>
            <a href="<?= url('admin/ligas') ?>">Ligas</a>
            <a href="<?= url('admin/categorias') ?>">Categorías</a>
            <a href="<?= url('admin/usuarios') ?>">Usuarios</a>
            <a href="<?= url('correos') ?>">Correos</a>
          <?php endif; ?>

          <span class="navegacion__usuario"><?= e($usuarioActual['nombre']) ?> <small><?= e($rolActual) ?></small></span>
          <form method="post" action="<?= url('logout') ?>" class="formulario-inline">
            <?= csrf_field() ?>
            <button type="submit" class="enlace-boton">Salir</button>
          </form>
        <?php else: ?>
          <a href="<?= url('login') ?>">Ingresar</a>
          <a class="boton boton--pequeno" href="<?= url('registro') ?>">Crear cuenta</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="contenedor principal">
    <?php foreach ($mensajes as $mensaje): ?>
      <div class="aviso aviso--<?= e($mensaje['tipo']) ?>" role="status"><?= e($mensaje['mensaje']) ?></div>
    <?php endforeach; ?>

    <?= $contenido ?>
  </main>

  <footer class="pie">
    <div class="contenedor pie__interno">
      <p>SportVibes — Ropa deportiva y Esports. Hecho en México.</p>
      <p><a href="<?= url('health') ?>">Estado del sistema</a> · &copy; <span data-anio><?= date('Y') ?></span></p>
    </div>
  </footer>
</body>
</html>
