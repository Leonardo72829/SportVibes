<?php
declare(strict_types=1);

/**
 * Inicializa la base SQLite local (desarrollo).
 * Uso: php database/inicializar.php
 * No destruye datos: ejecuta CREATE TABLE IF NOT EXISTS y luego actualiza el seed.
 */

require_once dirname(__DIR__) . '/app/core/Database.php';

$base = dirname(__DIR__) . '/database';
$pdo = Database::obtenerConexion();

function aplicarSql(PDO $pdo, string $archivo): void
{
    $sql = file_get_contents($archivo);
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

    echo 'Aplicado: ' . basename($archivo) . "\n";
}

aplicarSql($pdo, $base . '/schema.sqlite.sql');

// Las bases creadas antes de añadir la variante se actualizan sin perder datos.
$columnas = $pdo->query('PRAGMA table_info(productos)')->fetchAll(PDO::FETCH_ASSOC);
$tieneVariante = false;
foreach ($columnas as $columna) {
    if (($columna['name'] ?? '') === 'variante') {
        $tieneVariante = true;
        break;
    }
}
if (!$tieneVariante) {
    $pdo->exec("ALTER TABLE productos ADD COLUMN variante TEXT NOT NULL DEFAULT 'local'");
    echo "Añadida columna variante a productos\n";
}

aplicarSql($pdo, $base . '/seed.sqlite.sql');

$tablas = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
    ->fetchAll(PDO::FETCH_COLUMN);

echo 'Base lista en: ' . DB_PATH . "\n";
echo 'Tablas (' . count($tablas) . '): ' . implode(', ', $tablas) . "\n";
