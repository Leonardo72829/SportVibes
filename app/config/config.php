<?php
declare(strict_types=1);

/**
 * Configuración central de SportVibes.
 * Desarrollo: SQLite local. Producción: MySQL en el VPS.
 * Toda la configuración sensible se lee de .env (nunca versionado).
 */

function cargarArchivoEnv(string $archivo): array
{
    $datos = [];
    if (!is_file($archivo)) {
        return $datos;
    }

    foreach (file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);
        if ($linea === '' || str_starts_with($linea, '#')) {
            continue;
        }
        if (!str_contains($linea, '=')) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        if (strlen($valor) >= 2 && (($valor[0] === '"' && str_ends_with($valor, '"')) || ($valor[0] === "'" && str_ends_with($valor, "'")))) {
            $valor = substr($valor, 1, -1);
        }

        $datos[$clave] = $valor;
    }

    return $datos;
}

$entorno = cargarArchivoEnv(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env');

define('BASE_PATH', dirname(__DIR__, 2));
define('VISTAS_PATH', BASE_PATH . '/app/views');

define('APP_NAME', $entorno['APP_NAME'] ?? 'SportVibes');
define('APP_ENV', $entorno['APP_ENV'] ?? 'local');
define('APP_URL', rtrim($entorno['APP_URL'] ?? 'http://127.0.0.1:8000', '/'));
define('APP_DEBUG', filter_var($entorno['APP_DEBUG'] ?? 'true', FILTER_VALIDATE_BOOL));

define('DB_DRIVER', strtolower($entorno['DB_DRIVER'] ?? 'sqlite'));
define('DB_PATH', BASE_PATH . '/' . ($entorno['DB_PATH'] ?? 'database/sportvibes.sqlite'));
define('DB_HOST', $entorno['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $entorno['DB_PORT'] ?? '3306');
define('DB_NAME', $entorno['DB_NAME'] ?? 'sportvibes');
define('DB_USER', $entorno['DB_USER'] ?? 'sportvibes_user');
define('DB_PASS', $entorno['DB_PASS'] ?? '');

define('SMTP_HOST', $entorno['SMTP_HOST'] ?? '');
define('SMTP_PORT', (int) ($entorno['SMTP_PORT'] ?? 587));
define('SMTP_SEGURIDAD', $entorno['SMTP_SEGURIDAD'] ?? 'tls');
define('SMTP_USUARIO', $entorno['SMTP_USUARIO'] ?? '');
define('SMTP_CLAVE', $entorno['SMTP_CLAVE'] ?? '');
define('SMTP_FROM', $entorno['SMTP_FROM'] ?? 'no-reply@sportvibes.local');
define('SMTP_FROM_NOMBRE', $entorno['SMTP_FROM_NOMBRE'] ?? APP_NAME);

define('COSTO_ENVIO', (float) ($entorno['COSTO_ENVIO'] ?? 99));
define('ENVIO_MINIMO_GRATIS', (float) ($entorno['ENVIO_MINIMO_GRATIS'] ?? 0));

date_default_timezone_set($entorno['APP_TIMEZONE'] ?? 'America/Mexico_City');

if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => APP_ENV === 'production',
    ]);
    session_start();
}

// PHPMailer es opcional mientras SMTP_HOST esté vacío; si no se ejecutó
// `composer install`, el sistema sigue funcionando y solo guarda avisos internos.
$autoload = BASE_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}
require_once __DIR__ . '/../core/helpers.php';

/** Carga automática de clases del núcleo y de los controladores. */
spl_autoload_register(static function (string $clase): void {
    $archivo = BASE_PATH . '/app/core/' . $clase . '.php';
    if (!is_file($archivo)) {
        $archivo = BASE_PATH . '/app/controllers/' . $clase . '.php';
    }
    if (is_file($archivo)) {
        require_once $archivo;
    }
});
