<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-15, RF-23 y RF-24: reporte mensual, catálogo base y cuentas del personal. */
final class AdminController
{
    public static function reporte(): void
    {
        Auth::requerirRol(['administrador']);
        $mes = (string) ($_GET['mes'] ?? date('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $mes)) {
            $mes = date('Y-m');
        }

        $ventas = Database::uno(
            "SELECT COUNT(*) AS pedidos,
                    COALESCE(SUM(total), 0) AS ingresos,
                    COALESCE(SUM(envio), 0) AS envios
             FROM pedidos
             WHERE substr(fecha_pedido, 1, 7) = ? AND estado <> 'cancelado'",
            [$mes]
        );

        $utilidad = Database::uno(
            "SELECT COALESCE(SUM((d.precio_unitario - p.costo) * d.cantidad), 0) AS utilidad
             FROM pedido_detalle d
             JOIN productos p ON p.id = d.producto_id
             JOIN pedidos pe ON pe.id = d.pedido_id
             WHERE substr(pe.fecha_pedido, 1, 7) = ? AND pe.estado <> 'cancelado'",
            [$mes]
        );

        View::render('admin', [
            'mes' => $mes,
            'ventas' => $ventas,
            'utilidad' => $utilidad,
            'porLiga' => Database::todos(
                "SELECT l.nombre AS liga, COUNT(d.id) AS unidades,
                        COALESCE(SUM(d.precio_unitario * d.cantidad), 0) AS ingresos
                 FROM pedido_detalle d
                 JOIN pedidos pe ON pe.id = d.pedido_id
                 JOIN productos p ON p.id = d.producto_id
                 LEFT JOIN ligas l ON l.id = p.liga_id
                 WHERE substr(pe.fecha_pedido, 1, 7) = ? AND pe.estado <> 'cancelado'
                 GROUP BY l.id ORDER BY ingresos DESC",
                [$mes]
            ),
        ], 'Reporte mensual');
    }

    public static function ligas(): void
    {
        Auth::requerirRol(['administrador']);
        View::render('admin_ligas', [
            'ligas' => Database::todos('SELECT * FROM ligas ORDER BY id'),
        ], 'Ligas');
    }

    public static function guardarLiga(): void
    {
        Auth::requerirRol(['administrador']);
        requerirPost();
        validarCsrf();

        $nombre = Validator::texto($_POST['nombre'] ?? '', 2, 80);
        if ($nombre === null) {
            flash('error', 'El nombre de la liga no es válido.');
            redirect('admin/ligas');
        }
        if (Database::uno('SELECT id FROM ligas WHERE nombre = ?', [$nombre])) {
            flash('error', 'Esa liga ya existe.');
            redirect('admin/ligas');
        }

        Database::ejecutar(
            'INSERT INTO ligas (nombre, activa) VALUES (?, ?)',
            [$nombre, isset($_POST['activa']) ? 1 : 0]
        );
        flash('exito', 'Liga agregada al catálogo.');
        redirect('admin/ligas');
    }

    public static function categorias(): void
    {
        Auth::requerirRol(['administrador']);
        View::render('admin_categorias', [
            'categorias' => Database::todos(
                'SELECT c.*, l.nombre AS liga FROM categorias c
                 LEFT JOIN ligas l ON l.id = c.liga_id ORDER BY c.id'
            ),
            'ligas' => Database::todos('SELECT id, nombre FROM ligas ORDER BY id'),
        ], 'Categorías');
    }

    public static function guardarCategoria(): void
    {
        Auth::requerirRol(['administrador']);
        requerirPost();
        validarCsrf();

        $nombre = Validator::texto($_POST['nombre'] ?? '', 2, 80);
        $ligaId = Validator::entero($_POST['liga_id'] ?? null, 1);
        if ($nombre === null || $ligaId === null) {
            flash('error', 'Revisa el nombre y la liga de la categoría.');
            redirect('admin/categorias');
        }
        if (Database::uno('SELECT id FROM categorias WHERE nombre = ?', [$nombre])) {
            flash('error', 'Esa categoría ya existe.');
            redirect('admin/categorias');
        }

        Database::ejecutar(
            'INSERT INTO categorias (liga_id, nombre) VALUES (?, ?)',
            [$ligaId, $nombre]
        );
        flash('exito', 'Categoría agregada.');
        redirect('admin/categorias');
    }

    public static function usuarios(): void
    {
        Auth::requerirRol(['administrador']);
        View::render('admin_usuarios', [
            'usuarios' => Database::todos(
                'SELECT u.id, u.nombre, u.correo, u.activo, u.fecha_registro, r.nombre AS rol
                 FROM usuarios u JOIN roles r ON r.id = u.rol_id ORDER BY u.id'
            ),
            'roles' => Database::todos("SELECT id, nombre FROM roles WHERE nombre <> 'cliente' ORDER BY id"),
        ], 'Cuentas del personal');
    }

    public static function guardarUsuario(): void
    {
        Auth::requerirRol(['administrador']);
        requerirPost();
        validarCsrf();

        $nombre = Validator::texto($_POST['nombre'] ?? '', 2, 100);
        $correo = Validator::correo($_POST['correo'] ?? '');
        $clave = (string) ($_POST['clave'] ?? '');
        $rolId = Validator::entero($_POST['rol_id'] ?? null, 2, 5);

        if ($nombre === null || $correo === null || $rolId === null || mb_strlen($clave) < 8) {
            flash('error', 'Revisa los datos: nombre, correo, rol y contraseña de al menos 8 caracteres.');
            redirect('admin/usuarios');
        }
        if (Database::uno('SELECT id FROM usuarios WHERE correo = ?', [$correo])) {
            flash('error', 'Ese correo ya está registrado.');
            redirect('admin/usuarios');
        }

        Database::ejecutar(
            'INSERT INTO usuarios (rol_id, nombre, correo, contrasena_hash, activo) VALUES (?, ?, ?, ?, 1)',
            [$rolId, $nombre, $correo, password_hash($clave, PASSWORD_DEFAULT)]
        );
        flash('exito', 'Cuenta del personal creada.');
        redirect('admin/usuarios');
    }

    public static function cambiarEstadoUsuario(array $parametros): void
    {
        Auth::requerirRol(['administrador']);
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        if ($id !== null && $id !== (int) Auth::id()) {
            Database::ejecutar(
                'UPDATE usuarios SET activo = CASE WHEN activo = 1 THEN 0 ELSE 1 END WHERE id = ?',
                [$id]
            );
            flash('exito', 'Estado de la cuenta actualizado.');
        } else {
            flash('error', 'No puedes desactivar tu propia cuenta.');
        }
        redirect('admin/usuarios');
    }
}
