<?php
declare(strict_types=1);

/**
 * Inicializa la base SQLite local (desarrollo).
 * Uso: php database/inicializar.php
 * No destruye datos: ejecuta CREATE TABLE IF NOT EXISTS y luego el seed.
 */

require_once dirname(__DIR__) . '/app/core/Database.php';

$base = dirname(__DIR__) . '/database';
$pdo = Database::obtenerConexion();

foreach (['schema.sqlite.sql', 'seed.sqlite.sql'] as $archivo) {
    $sql = file_get_contents($base . '/' . $archivo);
    if ($sql === false) {
        throw new RuntimeException('No se pudo leer ' . $archivo);
    }

    foreach (explode(';', $sql) as $sentencia) {
        // Quitar comentarios de línea antes de decidir si la sentencia está vacía.
        $sentencia = trim((string) preg_replace('/^\s*--.*$/m', '', $sentencia));
        if ($sentencia === '') {
            continue;
        }
        $pdo->exec($sentencia);
    }

    echo "Aplicado: $archivo\n";
}

$tablas = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
    ->fetchAll(PDO::FETCH_COLUMN);

echo 'Base lista en: ' . DB_PATH . "\n";
echo 'Tablas (' . count($tablas) . '): ' . implode(', ', $tablas) . "\n";
