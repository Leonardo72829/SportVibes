<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-03 y RF-04: registro de artículos y control de existencias por talla. */
final class InventarioController
{
    public static function index(): void
    {
        Auth::requerirRol(['inventario', 'administrador']);
        View::render('inventario', [
            'productos' => Database::todos(
                'SELECT p.id, p.codigo_barras, p.nombre, p.precio, p.costo, p.activo,
                        l.nombre AS liga, COALESCE(SUM(i.existencias), 0) AS stock
                 FROM productos p
                 LEFT JOIN ligas l ON l.id = p.liga_id
                 LEFT JOIN inventario i ON i.producto_id = p.id
                 GROUP BY p.id ORDER BY p.id'
            ),
        ], 'Inventario');
    }

    public static function crearForm(): void
    {
        Auth::requerirRol(['inventario', 'administrador']);
        View::render('inventario_crear', [
            'ligas' => Database::todos('SELECT id, nombre FROM ligas WHERE activa = 1 ORDER BY id'),
            'categorias' => Database::todos('SELECT id, nombre FROM categorias ORDER BY id'),
            'tallas' => Database::todos('SELECT id, etiqueta FROM tallas ORDER BY id'),
        ], 'Registrar artículo');
    }

    public static function guardar(): void
    {
        Auth::requerirRol(['inventario', 'administrador']);
        requerirPost();
        validarCsrf();

        $codigo = Validator::texto($_POST['codigo_barras'] ?? '', 3, 64);
        $nombre = Validator::texto($_POST['nombre'] ?? '', 3, 150);
        $precio = Validator::decimal($_POST['precio'] ?? null, 1);
        $costo = Validator::decimal($_POST['costo'] ?? 0, 0);
        $ligaId = Validator::entero($_POST['liga_id'] ?? null, 1);
        $categoriaId = Validator::entero($_POST['categoria_id'] ?? null, 1);

        guardarOld($_POST);

        if ($codigo === null || $nombre === null || $precio === null || $costo === null) {
            flash('error', 'Revisa el código, nombre, precio y costo del artículo.');
            redirect('inventario/crear');
        }
        if (Database::uno('SELECT id FROM productos WHERE codigo_barras = ?', [$codigo])) {
            flash('error', 'Ese código de barras ya está registrado.');
            redirect('inventario/crear');
        }
        if ($costo > $precio) {
            flash('error', 'El costo no puede ser mayor que el precio de venta.');
            redirect('inventario/crear');
        }

        Database::ejecutar(
            'INSERT INTO productos
             (codigo_barras, nombre, descripcion, precio, costo, liga_id, categoria_id, personalizable, activo)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)',
            [
                $codigo,
                $nombre,
                Validator::texto($_POST['descripcion'] ?? '', 0, 1000),
                $precio,
                $costo,
                $ligaId,
                $categoriaId,
                isset($_POST['personalizable']) ? 1 : 0,
            ]
        );
        $productoId = (int) Database::obtenerConexion()->lastInsertId();

        foreach (Database::todos('SELECT id FROM tallas ORDER BY id') as $talla) {
            $existencias = Validator::entero($_POST['stock_' . $talla['id']] ?? 0, 0, 9999) ?? 0;
            Database::ejecutar(
                'INSERT INTO inventario (producto_id, talla_id, existencias) VALUES (?, ?, ?)',
                [$productoId, (int) $talla['id'], $existencias]
            );
        }

        limpiarOld();
        flash('exito', 'Artículo registrado con sus existencias.');
        redirect('inventario');
    }

    public static function stockForm(array $parametros): void
    {
        Auth::requerirRol(['inventario', 'administrador']);
        $id = Validator::entero($parametros[0] ?? null, 1);
        $producto = $id === null ? null : Database::uno('SELECT * FROM productos WHERE id = ?', [$id]);

        if ($producto === null) {
            http_response_code(404);
            View::render('404', [], 'Artículo no encontrado');
            return;
        }

        View::render('inventario_stock', [
            'producto' => $producto,
            'tallas' => Database::todos(
                'SELECT t.id, t.etiqueta, COALESCE(i.existencias, 0) AS existencias
                 FROM tallas t
                 LEFT JOIN inventario i ON i.talla_id = t.id AND i.producto_id = ?
                 ORDER BY t.id',
                [$id]
            ),
        ], 'Existencias de ' . $producto['nombre']);
    }

    public static function actualizarStock(array $parametros): void
    {
        Auth::requerirRol(['inventario', 'administrador']);
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        if ($id === null || Database::uno('SELECT id FROM productos WHERE id = ?', [$id]) === null) {
            flash('error', 'Artículo no encontrado.');
            redirect('inventario');
        }

        foreach (Database::todos('SELECT id FROM tallas') as $talla) {
            $cantidad = Validator::entero($_POST['stock_' . $talla['id']] ?? null, 0, 9999);
            if ($cantidad === null) {
                continue;
            }
            $existe = Database::uno(
                'SELECT producto_id FROM inventario WHERE producto_id = ? AND talla_id = ?',
                [$id, (int) $talla['id']]
            );
            if ($existe === null) {
                Database::ejecutar(
                    'INSERT INTO inventario (producto_id, talla_id, existencias) VALUES (?, ?, ?)',
                    [$id, (int) $talla['id'], $cantidad]
                );
            } else {
                Database::ejecutar(
                    'UPDATE inventario SET existencias = ? WHERE producto_id = ? AND talla_id = ?',
                    [$cantidad, $id, (int) $talla['id']]
                );
            }
        }

        flash('exito', 'Existencias actualizadas.');
        redirect('inventario/stock/' . $id);
    }
}
