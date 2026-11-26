<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Database.php';

/** RF-05, RF-06 y RF-23: catálogo por liga, detalle de prenda y Esports. */
final class CatalogoController
{
    public static function inicio(): void
    {
        $ligas = Database::todos('SELECT id, nombre FROM ligas WHERE activa = 1 ORDER BY id');
        $destacados = Database::todos(
            'SELECT p.*, l.nombre AS liga, COALESCE(SUM(i.existencias), 0) AS stock
             FROM productos p
             LEFT JOIN ligas l ON l.id = p.liga_id
             LEFT JOIN inventario i ON i.producto_id = p.id
             WHERE p.activo = 1
             GROUP BY p.id
             ORDER BY p.id
             LIMIT 4'
        );

        View::render('inicio', ['ligas' => $ligas, 'destacados' => $destacados], 'Inicio');
    }

    public static function index(): void
    {
        $ligaId = Validator::entero($_GET['liga'] ?? null, 1);
        $busqueda = trim((string) ($_GET['q'] ?? ''));
        if (mb_strlen($busqueda) > 80) {
            $busqueda = mb_substr($busqueda, 0, 80);
        }

        $where = ['p.activo = 1'];
        $parametros = [];
        if ($ligaId !== null) {
            $where[] = 'p.liga_id = ?';
            $parametros[] = $ligaId;
        }
        if ($busqueda !== '') {
            $where[] = '(p.nombre LIKE ? OR p.descripcion LIKE ?)';
            $parametros[] = '%' . $busqueda . '%';
            $parametros[] = '%' . $busqueda . '%';
        }

        $productos = Database::todos(
            'SELECT p.*, l.nombre AS liga, COALESCE(SUM(i.existencias), 0) AS stock
             FROM productos p
             LEFT JOIN ligas l ON l.id = p.liga_id
             LEFT JOIN inventario i ON i.producto_id = p.id
             WHERE ' . implode(' AND ', $where) . '
             GROUP BY p.id
             ORDER BY p.id',
            $parametros
        );
        $ligas = Database::todos('SELECT id, nombre FROM ligas WHERE activa = 1 ORDER BY id');

        View::render('catalogo', [
            'productos' => $productos,
            'ligas' => $ligas,
            'liga_activa' => $ligaId,
            'busqueda' => $busqueda,
        ], 'Catálogo');
    }

    public static function detalle(array $parametros): void
    {
        $id = Validator::entero($parametros[0] ?? null, 1);
        $producto = $id === null ? null : Database::uno(
            'SELECT p.*, l.nombre AS liga, c.nombre AS categoria
             FROM productos p
             LEFT JOIN ligas l ON l.id = p.liga_id
             LEFT JOIN categorias c ON c.id = p.categoria_id
             WHERE p.id = ? AND p.activo = 1',
            [$id]
        );

        if ($producto === null) {
            http_response_code(404);
            View::render('404', [], 'Producto no encontrado');
            return;
        }

        $tallas = Database::todos(
            'SELECT t.id, t.etiqueta, COALESCE(i.existencias, 0) AS existencias
             FROM tallas t
             LEFT JOIN inventario i ON i.talla_id = t.id AND i.producto_id = ?
             ORDER BY t.id',
            [$id]
        );

        View::render('producto', ['producto' => $producto, 'tallas' => $tallas], $producto['nombre']);
    }
}
