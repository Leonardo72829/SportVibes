<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Mailer.php';

/**
 * RF-12, RF-18 y RF-19: preparación, envío y seguimiento.
 * SP07: aviso por correo con número de guía. SP09: solo logística cambia el estado.
 */
final class LogisticaController
{
    private const ESTADOS = ['en_preparacion', 'enviado', 'entregado'];

    public static function index(): void
    {
        Auth::requerirRol(['logistica']);
        View::render('logistica', [
            'pedidos' => Database::todos(
                "SELECT p.id, p.numero_pedido, p.estado, p.total, p.numero_guia, p.fecha_pago,
                        u.nombre AS cliente, u.correo,
                        (SELECT COUNT(*) FROM pedido_detalle d WHERE d.pedido_id = p.id) AS articulos
                 FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id
                 WHERE p.estado IN ('pagado','en_preparacion','enviado')
                 ORDER BY p.id"
            ),
            'estados' => self::ESTADOS,
        ], 'Logística');
    }

    public static function registrarGuia(array $parametros): void
    {
        Auth::requerirRol(['logistica']);
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        $guia = Validator::texto($_POST['numero_guia'] ?? '', 4, 60);
        $pedido = $id === null ? null : self::pedido($id);

        if ($pedido === null || $guia === null) {
            flash('error', 'Revisa el pedido y el número de guía.');
            redirect('logistica');
        }
        if (!in_array($pedido['estado'], ['pagado', 'en_preparacion'], true)) {
            flash('error', 'Ese pedido ya tiene guía o no está listo para envío.');
            redirect('logistica');
        }

        Database::ejecutar('UPDATE pedidos SET numero_guia = ? WHERE id = ?', [$guia, $id]);
        flash('exito', 'Número de guía registrado.');
        redirect('logistica');
    }

    public static function cambiarEstado(array $parametros): void
    {
        Auth::requerirRol(['logistica']);
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        $estado = (string) ($_POST['estado'] ?? '');
        $guia = Validator::texto($_POST['numero_guia'] ?? '', 4, 60);
        $pedido = $id === null ? null : self::pedido($id);

        if ($pedido === null || !in_array($estado, self::ESTADOS, true)) {
            flash('error', 'Estado no válido.');
            redirect('logistica');
        }

        if ($estado === 'enviado' && $guia === null && $pedido['numero_guia'] === null) {
            flash('error', 'Registra el número de guía antes de marcar el pedido como enviado.');
            redirect('logistica');
        }

        $numeroGuia = $guia ?? $pedido['numero_guia'];
        Database::ejecutar(
            'UPDATE pedidos SET estado = ?, numero_guia = ? WHERE id = ?',
            [$estado, $numeroGuia, $id]
        );
        Database::ejecutar(
            'INSERT INTO historial_estados (pedido_id, estado, usuario_id) VALUES (?, ?, ?)',
            [$id, $estado, (int) Auth::id()]
        );

        // SP07: el cliente recibe el aviso con el número de guía.
        $mensaje = '<p>Hola ' . e($pedido['cliente']) . ':</p><p>Tu pedido <strong>' .
            e($pedido['numero_pedido']) . '</strong> ahora está <strong>' . e(str_replace('_', ' ', $estado)) .
            '</strong>.</p>';
        if ($numeroGuia !== null) {
            $mensaje .= '<p>Número de guía: <strong>' . e($numeroGuia) . '</strong>.</p>';
        }

        Mailer::enviar(
            (string) $pedido['correo'],
            (string) $pedido['cliente'],
            'Actualización de tu pedido ' . $pedido['numero_pedido'],
            $mensaje,
            'cambio_estado',
            $id
        );

        flash('exito', 'Estado del pedido actualizado y cliente notificado.');
        redirect('logistica');
    }

    private static function pedido(int $id): ?array
    {
        return Database::uno(
            'SELECT p.*, u.nombre AS cliente, u.correo
             FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id
             WHERE p.id = ?',
            [$id]
        );
    }
}
