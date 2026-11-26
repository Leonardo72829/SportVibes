<?php
declare(strict_types=1);

/**
 * Configuración central de SportVibes.
 * Lee las variables de .env (solo local/VPS) y define las constantes de la app.
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

define('APP_NAME', $entorno['APP_NAME'] ?? 'SportVibes');
define('APP_ENV', $entorno['APP_ENV'] ?? 'production');
define('APP_URL', rtrim($entorno['APP_URL'] ?? 'http://localhost', '/'));
define('APP_DEBUG', filter_var($entorno['APP_DEBUG'] ?? 'false', FILTER_VALIDATE_BOOL));

define('DB_HOST', $entorno['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $entorno['DB_PORT'] ?? '3306');
define('DB_NAME', $entorno['DB_NAME'] ?? 'sportvibes');
define('DB_USER', $entorno['DB_USER'] ?? 'sportvibes_user');
define('DB_PASS', $entorno['DB_PASS'] ?? '');

date_default_timezone_set($entorno['APP_TIMEZONE'] ?? 'America/Mexico_City');

if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}
