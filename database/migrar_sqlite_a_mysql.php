<?php
declare(strict_types=1);

/**
 * Genera las sentencias SQL necesarias para migrar los datos locales de SQLite a MySQL.
 * Uso: php database/migrar_sqlite_a_mysql.php
 * Salida: database/migracion_datos.sql (no se versiona; puede contener datos reales).
 *
 * En el VPS, después de importar database/schema.sql y database/seed.sql:
 *   mysql -u sportvibes_user -p sportvibes < database/migracion_datos.sql
 */

require_once dirname(__DIR__) . '/app/config/config.php';

/** Orden seguro respetando llaves foráneas. */
const TABLAS = [
    'roles', 'usuarios', 'ligas', 'categorias', 'tallas', 'productos', 'inventario',
    'direcciones', 'carrito', 'pedidos', 'pedido_detalle', 'pagos',
    'historial_estados', 'consultas', 'consulta_respuestas', 'notificaciones',
];

function valorSql(mixed $valor): string
{
    if ($valor === null) {
        return 'NULL';
    }
    if (is_int($valor) || is_float($valor)) {
        return (string) $valor;
    }
    return "'" . str_replace(['\\', "'", "\n", "\r"], ['\\\\', "\\'", '\\n', '\\r'], (string) $valor) . "'";
}

$origen = new PDO('sqlite:' . DB_PATH, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$sql = "-- SportVibes — Datos exportados de SQLite para importar en MySQL.\n";
$sql .= "-- Generado: " . date('Y-m-d H:i:s') . "\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

foreach (TABLAS as $tabla) {
    $existe = $origen->query("SELECT 1 FROM sqlite_master WHERE type='table' AND name='" . $tabla . "'")->fetchColumn();
    if (!$existe) {
        continue;
    }

    $filas = $origen->query('SELECT * FROM ' . $tabla)->fetchAll();
    $sql .= '-- ' . $tabla . ' (' . count($filas) . " filas)\n";
    foreach ($filas as $fila) {
        $columnas = '`' . implode('`, `', array_keys($fila)) . '`';
        $valores = implode(', ', array_map('valorSql', array_values($fila)));
        $sql .= 'INSERT IGNORE INTO `' . $tabla . '` (' . $columnas . ') VALUES (' . $valores . ");\n";
    }
    $sql .= "\n";
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

$destino = dirname(__DIR__) . '/database/migracion_datos.sql';
file_put_contents($destino, $sql);

echo "Exportación generada: $destino\n";
echo "Tablas exportadas: " . count(TABLAS) . "\n";
echo "Ahora, en el VPS ejecuta:\n";
echo "  mysql -u sportvibes_user -p sportvibes < database/migracion_datos.sql\n";
