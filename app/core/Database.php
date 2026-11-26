<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

/**
 * Conexión PDO centralizada a MySQL.
 * Todas las consultas se ejecutan con sentencias preparadas.
 */
final class Database
{
    private static ?PDO $conexion = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$conexion === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                DB_HOST,
                DB_PORT,
                DB_NAME
            );

            self::$conexion = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$conexion;
    }

    public static function consultar(string $sql, array $parametros = []): PDOStatement
    {
        $sentencia = self::obtenerConexion()->prepare($sql);
        $sentencia->execute($parametros);

        return $sentencia;
    }
}
