<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

/**
 * Conexión PDO centralizada.
 * DB_DRIVER=sqlite para desarrollo local; DB_DRIVER=mysql para el VPS.
 */
final class Database
{
    private static ?PDO $conexion = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$conexion === null) {
            if (DB_DRIVER === 'sqlite') {
                $directorio = dirname(DB_PATH);
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0775, true);
                }
                self::$conexion = new PDO('sqlite:' . DB_PATH, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                self::$conexion->exec('PRAGMA foreign_keys = ON');
            } else {
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
        }

        return self::$conexion;
    }

    public static function consultar(string $sql, array $parametros = []): PDOStatement
    {
        $sentencia = self::obtenerConexion()->prepare($sql);
        $sentencia->execute($parametros);
        return $sentencia;
    }

    public static function uno(string $sql, array $parametros = []): ?array
    {
        $fila = self::consultar($sql, $parametros)->fetch();
        return $fila === false ? null : $fila;
    }

    public static function todos(string $sql, array $parametros = []): array
    {
        return self::consultar($sql, $parametros)->fetchAll();
    }

    public static function ejecutar(string $sql, array $parametros = []): int
    {
        self::consultar($sql, $parametros);
        return self::obtenerConexion()->lastInsertId() !== false
            ? (int) self::obtenerConexion()->lastInsertId()
            : 0;
    }
}
