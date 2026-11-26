<?php
declare(strict_types=1);

/** Renderizado de plantillas con layout compartido. */
final class View
{
    public static function render(string $vista, array $datos = [], string $titulo = ''): void
    {
        extract($datos, EXTR_SKIP);

        ob_start();
        include VISTAS_PATH . '/' . str_replace('/', '/', $vista) . '.php';
        $contenido = ob_get_clean();

        include VISTAS_PATH . '/layout.php';
    }
}
