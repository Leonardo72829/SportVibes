<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-08 y RF-09: carrito de compras y personalización (RF-07). */
final class CarritoController
{
    public static function index(): void
    {
        Auth::requerirLogin();
        $items = self::obtenerItems((int) Auth::id());
        $totales = self::calcularTotales($items);

        View::render('carrito', ['items' => $items] + $totales, 'Mi carrito');
    }

    public static function agregar(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $productoId = Validator::entero($_POST['producto_id'] ?? null, 1);
        $tallaId = Validator::entero($_POST['talla_id'] ?? null, 1);
        $cantidad = Validator::entero($_POST['cantidad'] ?? 1, 1, 20);
        $nombre = trim((string) ($_POST['nombre_personalizado'] ?? ''));
        $dorsal = Validator::entero($_POST['dorsal'] ?? null, 0, 99);

        if ($productoId === null || $tallaId === null || $cantidad === null) {
            flash('error', 'Revisa la talla y la cantidad seleccionadas.');
            redirect('producto/' . (int) $productoId);
        }

        $producto = Database::uno(
            'SELECT id, nombre, personalizable FROM productos WHERE id = ? AND activo = 1',
            [$productoId]
        );
        $inventario = Database::uno(
            'SELECT existencias FROM inventario WHERE producto_id = ? AND talla_id = ?',
            [$productoId, $tallaId]
        );

        if ($producto === null || $inventario === null) {
            flash('error', 'Ese producto o talla no está disponible.');
            redirect('catalogo');
        }
        if ((int) $inventario['existencias'] < $cantidad) {
            flash('error', 'No hay existencias suficientes para esa talla.');
            redirect('producto/' . $productoId);
        }

        $nombre = mb_substr($nombre, 0, 12);
        if ($nombre !== '' && !Validator::palabraSegura($nombre)) {
            flash('error', 'El nombre personalizado contiene una palabra no permitida.');
            redirect('producto/' . $productoId);
        }
        if ((int) $producto['personalizable'] === 0) {
            $nombre = '';
            $dorsal = null;
        }

        $usuarioId = (int) Auth::id();
        $actual = Database::uno(
            'SELECT cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?',
            [$usuarioId, $productoId, $tallaId]
        );

        if ($actual !== null) {
            Database::ejecutar(
                'UPDATE carrito SET cantidad = cantidad + ?, nombre_personalizado = ?, dorsal = ?
                 WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?',
                [$cantidad, $nombre !== '' ? $nombre : null, $dorsal, $usuarioId, $productoId, $tallaId]
            );
        } else {
            Database::ejecutar(
                'INSERT INTO carrito (usuario_id, producto_id, talla_id, cantidad, nombre_personalizado, dorsal)
                 VALUES (?, ?, ?, ?, ?, ?)',
                [$usuarioId, $productoId, $tallaId, $cantidad, $nombre !== '' ? $nombre : null, $dorsal]
            );
        }

        flash('exito', 'Agregaste ' . $producto['nombre'] . ' al carrito.');
        redirect('carrito');
    }

    public static function actualizar(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $productoId = Validator::entero($_POST['producto_id'] ?? null, 1);
        $tallaId = Validator::entero($_POST['talla_id'] ?? null, 1);
        $cantidad = Validator::entero($_POST['cantidad'] ?? null, 0, 20);
        $usuarioId = (int) Auth::id();

        if ($productoId === null || $tallaId === null || $cantidad === null) {
            flash('error', 'No se pudo actualizar el carrito.');
            redirect('carrito');
        }

        if ($cantidad === 0) {
            self::eliminarItem($usuarioId, $productoId, $tallaId);
            flash('exito', 'El artículo se quitó del carrito.');
            redirect('carrito');
        }

        $inventario = Database::uno(
            'SELECT existencias FROM inventario WHERE producto_id = ? AND talla_id = ?',
            [$productoId, $tallaId]
        );
        if ($inventario === null || (int) $inventario['existencias'] < $cantidad) {
            flash('error', 'No hay existencias suficientes para esa cantidad.');
            redirect('carrito');
        }

        Database::ejecutar(
            'UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?',
            [$cantidad, $usuarioId, $productoId, $tallaId]
        );
        flash('exito', 'Cantidad actualizada.');
        redirect('carrito');
    }

    public static function quitar(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $productoId = Validator::entero($_POST['producto_id'] ?? null, 1);
        $tallaId = Validator::entero($_POST['talla_id'] ?? null, 1);
        if ($productoId !== null && $tallaId !== null) {
            self::eliminarItem((int) Auth::id(), $productoId, $tallaId);
            flash('exito', 'El artículo se quitó del carrito.');
        }
        redirect('carrito');
    }

    public static function obtenerItems(int $usuarioId): array
    {
        return Database::todos(
            'SELECT c.*, p.nombre, p.precio, p.imagen, t.etiqueta AS talla,
                    COALESCE(i.existencias, 0) AS existencias
             FROM carrito c
             JOIN productos p ON p.id = c.producto_id
             JOIN tallas t ON t.id = c.talla_id
             LEFT JOIN inventario i ON i.producto_id = c.producto_id AND i.talla_id = c.talla_id
             WHERE c.usuario_id = ?
             ORDER BY c.producto_id',
            [$usuarioId]
        );
    }

    public static function calcularTotales(array $items): array
    {
        $subtotal = 0.0;
        foreach ($items as $item) {
            $subtotal += (float) $item['precio'] * (int) $item['cantidad'];
        }
        $envio = $subtotal > 0 ? COSTO_ENVIO : 0.0;

        return ['subtotal' => $subtotal, 'envio' => $envio, 'total' => $subtotal + $envio];
    }

    private static function eliminarItem(int $usuarioId, int $productoId, int $tallaId): void
    {
        Database::ejecutar(
            'DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?',
            [$usuarioId, $productoId, $tallaId]
        );
    }
}
