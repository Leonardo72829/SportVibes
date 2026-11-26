<?php
declare(strict_types=1);

/** Endpoint de verificación para el VPS y monitoreo básico. */
final class RutasController
{
    public static function health(array $parametros = []): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $estadoBase = 'ok';
        $detalle = 'SQLite local';
        try {
            Database::uno('SELECT 1 AS ok');
        } catch (Throwable $error) {
            $estadoBase = 'error';
            $detalle = 'Sin conexión a la base de datos';
        }

        echo json_encode([
            'estado' => $estadoBase,
            'aplicacion' => APP_NAME,
            'entorno' => APP_ENV,
            'base_de_datos' => DB_DRIVER,
            'detalle' => $detalle,
            'fecha' => date(DATE_ATOM),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
