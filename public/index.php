<?php
declare(strict_types=1);

/**
 * Controlador frontal de SportVibes.
 * Todas las peticiones pasan por aquí; el document root del VPS es public/.
 */

require_once __DIR__ . '/../app/config/config.php';

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

$ruta = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$ruta = rtrim((string) $ruta, '/') ?: '/';
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Con el servidor integrado de PHP, devolver false permite que sirva directamente
// los archivos estáticos (CSS, JS, imágenes). En Nginx estos se sirven sin pasar por aquí.
$archivoSolicitado = realpath(__DIR__ . $ruta);
$raizPublica = realpath(__DIR__);
if (
    $ruta !== '/' &&
    $archivoSolicitado !== false &&
    $raizPublica !== false &&
    str_starts_with($archivoSolicitado, $raizPublica . DIRECTORY_SEPARATOR) &&
    is_file($archivoSolicitado)
) {
    return false;
}

/**
 * Tabla de rutas: [método HTTP, patrón de URL, controlador, acción].
 * Las rutas estáticas van antes que las dinámicas para evitar ambigüedades.
 */
$rutas = [
    ['GET',  '#^/$#',                         'CatalogoController',      'inicio'],
    ['GET',  '#^/health$#',                   'RutasController',         'health'],

    // Catálogo
    ['GET',  '#^/catalogo$#',                 'CatalogoController',      'index'],
    ['GET',  '#^/producto/(\d+)$#',           'CatalogoController',      'detalle'],

    // Cuentas (RF-01, RF-02)
    ['GET',  '#^/login$#',                    'CuentasController',       'loginForm'],
    ['POST', '#^/login$#',                    'CuentasController',       'login'],
    ['GET',  '#^/registro$#',                 'CuentasController',       'registroForm'],
    ['POST', '#^/registro$#',                 'CuentasController',       'registrar'],
    ['POST', '#^/logout$#',                   'CuentasController',       'logout'],

    // Carrito (RF-07 a RF-09)
    ['GET',  '#^/carrito$#',                  'CarritoController',       'index'],
    ['POST', '#^/carrito/agregar$#',          'CarritoController',       'agregar'],
    ['POST', '#^/carrito/actualizar$#',       'CarritoController',       'actualizar'],
    ['POST', '#^/carrito/quitar$#',           'CarritoController',       'quitar'],

    // Pedidos, pago y seguimiento (RF-10 a RF-14, RF-16, RF-17)
    ['GET',  '#^/checkout$#',                 'PedidosController',       'checkout'],
    ['POST', '#^/direcciones$#',              'PedidosController',       'guardarDireccion'],
    ['POST', '#^/pedidos$#',                  'PedidosController',       'crear'],
    ['GET',  '#^/pedidos$#',                  'PedidosController',       'historial'],
    ['GET',  '#^/pedidos/(\d+)$#',            'PedidosController',       'detalle'],

    // Consultas y notificaciones (RF-14, RF-20 a RF-22)
    ['GET',  '#^/consultas$#',                'ConsultasController',     'index'],
    ['POST', '#^/consultas$#',                'ConsultasController',     'crear'],
    ['GET',  '#^/consultas/(\d+)$#',          'ConsultasController',     'detalle'],
    ['GET',  '#^/notificaciones$#',           'NotificacionesController','index'],
    ['POST', '#^/notificaciones/(\d+)/leida$#', 'NotificacionesController', 'marcarLeida'],

    // Inventario (RF-03, RF-04)
    ['GET',  '#^/inventario$#',               'InventarioController',    'index'],
    ['GET',  '#^/inventario/crear$#',         'InventarioController',    'crearForm'],
    ['POST', '#^/inventario$#',               'InventarioController',    'guardar'],
    ['GET',  '#^/inventario/stock/(\d+)$#',   'InventarioController',    'stockForm'],
    ['POST', '#^/inventario/stock/(\d+)$#',   'InventarioController',    'actualizarStock'],

    // Logística (RF-12, RF-18, RF-19)
    ['GET',  '#^/logistica$#',                'LogisticaController',     'index'],
    ['POST', '#^/logistica/(\d+)/guia$#',     'LogisticaController',     'registrarGuia'],
    ['POST', '#^/logistica/(\d+)/estado$#',   'LogisticaController',     'cambiarEstado'],

    // Soporte (RF-21, RF-22)
    ['GET',  '#^/soporte$#',                  'SoporteController',       'index'],
    ['GET',  '#^/soporte/(\d+)$#',            'SoporteController',       'detalle'],
    ['POST', '#^/soporte/(\d+)/responder$#',  'SoporteController',       'responder'],

    // Administración (RF-15, RF-23, RF-24)
    ['GET',  '#^/admin$#',                    'AdminController',         'reporte'],
    ['GET',  '#^/admin/ligas$#',              'AdminController',         'ligas'],
    ['POST', '#^/admin/ligas$#',              'AdminController',         'guardarLiga'],
    ['GET',  '#^/admin/categorias$#',         'AdminController',         'categorias'],
    ['POST', '#^/admin/categorias$#',         'AdminController',         'guardarCategoria'],
    ['GET',  '#^/admin/usuarios$#',           'AdminController',         'usuarios'],
    ['POST', '#^/admin/usuarios$#',           'AdminController',         'guardarUsuario'],
    ['POST', '#^/admin/usuarios/(\d+)/estado$#', 'AdminController',      'cambiarEstadoUsuario'],
    ['GET',  '#^/correos$#',                   'AdminController',         'correos'],
    ['GET',  '#^/correos/ver$#',               'AdminController',         'verCorreo'],
];

try {
    $encontrada = false;

    foreach ($rutas as [$metodoRuta, $patron, $controlador, $accion]) {
        if ($metodoRuta !== $metodo || !preg_match($patron, $ruta, $coincidencias)) {
            continue;
        }

        $encontrada = true;
        $parametros = array_slice($coincidencias, 1);
        $controlador::$accion($parametros);
        break;
    }

    if (!$encontrada) {
        http_response_code(404);
        View::render('404', [], 'Página no encontrada');
    }
} catch (Throwable $error) {
    error_log('SportVibes: ' . $error->getMessage());
    http_response_code(500);
    View::render('error', [
        'mensaje' => APP_DEBUG ? $error->getMessage() : 'Ocurrió un problema inesperado. Inténtalo más tarde.',
    ], 'Error del servidor');
}
