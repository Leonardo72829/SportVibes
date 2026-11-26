<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';

$ruta = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$ruta = rtrim((string) $ruta, '/') ?: '/';

switch ($ruta) {
    case '/':
        require __DIR__ . '/../app/views/inicio.php';
        break;

    case '/health':
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'estado' => 'ok',
            'aplicacion' => APP_NAME,
            'entorno' => APP_ENV,
            'fecha' => date(DATE_ATOM),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/../app/views/404.php';
        break;
}
