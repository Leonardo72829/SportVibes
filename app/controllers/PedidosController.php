<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Mailer.php';
require_once __DIR__ . '/../core/PagoSimulado.php';
require_once __DIR__ . '/CarritoController.php';

/**
 * RF-10 a RF-14, RF-16, RF-17 y RF-19: dirección, pedido, pago simulado,
 * desconto automático de existencias (SP08) y correo de confirmación (RF-14).
 */
final class PedidosController
{
    public static function checkout(): void
    {
        Auth::requerirLogin();
        $usuarioId = (int) Auth::id();
        $items = CarritoController::obtenerItems($usuarioId);
        if ($items === []) {
            flash('error', 'Tu carrito está vacío.');
            redirect('carrito');
        }

        View::render('checkout', [
            'items' => $items,
            'direcciones' => Database::todos(
                'SELECT * FROM direcciones WHERE usuario_id = ? ORDER BY id DESC',
                [$usuarioId]
            ),
        ] + CarritoController::calcularTotales($items), 'Finalizar compra');
    }

    public static function guardarDireccion(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $datos = self::validarDireccion($_POST);
        if ($datos === null) {
            flash('error', 'Revisa los datos de la dirección. El código postal debe tener 5 dígitos.');
            redirect('checkout');
        }

        Database::ejecutar(
            'INSERT INTO direcciones (usuario_id, calle, numero_ext, colonia, codigo_postal, ciudad, estado, referencia)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [(int) Auth::id()] + $datos
        );
        flash('exito', 'Dirección guardada.');
        redirect('checkout');
    }

    public static function crear(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $usuarioId = (int) Auth::id();
        $items = CarritoController::obtenerItems($usuarioId);
        if ($items === []) {
            flash('error', 'Tu carrito está vacío.');
            redirect('carrito');
        }

        foreach ($items as $item) {
            if ((int) $item['existencias'] < (int) $item['cantidad']) {
                flash('error', 'Ya no hay suficientes existencias de ' . $item['nombre'] . ' (talla ' . $item['talla'] . ').');
                redirect('carrito');
            }
        }

        $direccionId = Validator::entero($_POST['direccion_id'] ?? null, 1);
        if ($direccionId === null) {
            $datos = self::validarDireccion($_POST);
            if ($datos === null) {
                flash('error', 'Captura una dirección de entrega válida.');
                redirect('checkout');
            }
            Database::ejecutar(
                'INSERT INTO direcciones (usuario_id, calle, numero_ext, colonia, codigo_postal, ciudad, estado, referencia)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                [$usuarioId] + $datos
            );
            $direccionId = (int) Database::obtenerConexion()->lastInsertId();
        } else {
            $pertenece = Database::uno(
                'SELECT id FROM direcciones WHERE id = ? AND usuario_id = ?',
                [$direccionId, $usuarioId]
            );
            if ($pertenece === null) {
                flash('error', 'La dirección seleccionada no es válida.');
                redirect('checkout');
            }
        }

        $totales = CarritoController::calcularTotales($items);
        $numeroPedido = 'SV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        Database::ejecutar(
            'INSERT INTO pedidos (numero_pedido, usuario_id, direccion_id, estado, subtotal, envio, total)
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$numeroPedido, $usuarioId, $direccionId, 'pendiente', $totales['subtotal'], $totales['envio'], $totales['total']]
        );
        $pedidoId = (int) Database::obtenerConexion()->lastInsertId();

        foreach ($items as $item) {
            Database::ejecutar(
                'INSERT INTO pedido_detalle
                 (pedido_id, producto_id, talla_id, cantidad, precio_unitario, nombre_personalizado, dorsal)
                 VALUES (?, ?, ?, ?, ?, ?, ?)',
                [
                    $pedidoId,
                    (int) $item['producto_id'],
                    (int) $item['talla_id'],
                    (int) $item['cantidad'],
                    (float) $item['precio'],
                    $item['nombre_personalizado'] !== '' ? $item['nombre_personalizado'] : null,
                    $item['dorsal'] !== null ? (int) $item['dorsal'] : null,
                ]
            );
        }

        $resultado = (string) ($_POST['resultado'] ?? 'aprobado');
        $pago = PagoSimulado::procesar($totales['total'], $resultado);
        Database::ejecutar(
            'INSERT INTO pagos (pedido_id, pasarela, referencia, monto, estado) VALUES (?, ?, ?, ?, ?)',
            [$pedidoId, 'simulada', $pago['referencia'], $pago['monto'], $pago['aprobado'] ? 'aprobado' : 'rechazado']
        );

        $usuario = Auth::usuario();
        if ($pago['aprobado']) {
            Database::ejecutar(
                "UPDATE pedidos SET estado = 'pagado', fecha_pago = CURRENT_TIMESTAMP WHERE id = ?",
                [$pedidoId]
            );

            // SP08: descontar existencias automáticamente al confirmar el pago.
            foreach ($items as $item) {
                Database::ejecutar(
                    'UPDATE inventario SET existencias = existencias - ?
                     WHERE producto_id = ? AND talla_id = ?',
                    [(int) $item['cantidad'], (int) $item['producto_id'], (int) $item['talla_id']]
                );
            }

            Database::ejecutar(
                'DELETE FROM carrito WHERE usuario_id = ?',
                [$usuarioId]
            );
            self::registrarHistorial($pedidoId, 'pagado', $usuarioId);

            Mailer::enviar(
                (string) $usuario['correo'],
                (string) $usuario['nombre'],
                'Confirmación de tu pedido ' . $numeroPedido,
                '<p>Hola ' . e($usuario['nombre']) . ':</p><p>Tu pedido <strong>' . $numeroPedido .
                '</strong> fue confirmado por un total de ' . dinero($totales['total']) .
                ' (envío: ' . dinero($totales['envio']) . '). Revisa el seguimiento en tu cuenta.</p>',
                'confirmacion',
                $pedidoId
            );

            flash('exito', '¡Pedido confirmado! Revisa el seguimiento y tu correo.');
        } else {
            Database::ejecutar("UPDATE pedidos SET estado = 'cancelado' WHERE id = ?", [$pedidoId]);
            self::registrarHistorial($pedidoId, 'cancelado', $usuarioId);
            Mailer::enviar(
                (string) $usuario['correo'],
                (string) $usuario['nombre'],
                'Pedido rechazado ' . $numeroPedido,
                '<p>Hola ' . e($usuario['nombre']) . ':</p><p>El pago de tu pedido <strong>' . $numeroPedido .
                '</strong> fue rechazado. Tu carrito se conserva para que puedas intentarlo de nuevo.</p>',
                'cambio_estado',
                $pedidoId
            );
            flash('error', 'El pago fue rechazado. Tu carrito se conserva para intentarlo otra vez.');
        }

        redirect('pedidos/' . $pedidoId);
    }

    public static function historial(): void
    {
        Auth::requerirLogin();
        $pedidos = Database::todos(
            'SELECT id, numero_pedido, estado, total, fecha_pedido, numero_guia
             FROM pedidos WHERE usuario_id = ? ORDER BY id DESC',
            [(int) Auth::id()]
        );
        View::render('pedidos', ['pedidos' => $pedidos], 'Mis pedidos');
    }

    public static function detalle(array $parametros): void
    {
        Auth::requerirLogin();
        $id = Validator::entero($parametros[0] ?? null, 1);
        $pedido = $id === null ? null : Database::uno(
            'SELECT p.*, d.calle, d.numero_ext, d.colonia, d.codigo_postal, d.ciudad, d.estado
             FROM pedidos p JOIN direcciones d ON d.id = p.direccion_id
             WHERE p.id = ? AND p.usuario_id = ?',
            [$id, (int) Auth::id()]
        );

        if ($pedido === null) {
            http_response_code(404);
            View::render('404', [], 'Pedido no encontrado');
            return;
        }

        View::render('pedido_detalle', [
            'pedido' => $pedido,
            'items' => Database::todos(
                'SELECT pd.*, p.nombre, t.etiqueta AS talla
                 FROM pedido_detalle pd
                 JOIN productos p ON p.id = pd.producto_id
                 JOIN tallas t ON t.id = pd.talla_id
                 WHERE pd.pedido_id = ? ORDER BY pd.id',
                [$id]
            ),
            'pagos' => Database::todos('SELECT * FROM pagos WHERE pedido_id = ?', [$id]),
            'historial' => Database::todos(
                'SELECT h.*, u.nombre AS usuario FROM historial_estados h
                 JOIN usuarios u ON u.id = h.usuario_id
                 WHERE h.pedido_id = ? ORDER BY h.id',
                [$id]
            ),
        ], 'Pedido ' . $pedido['numero_pedido']);
    }

    private static function registrarHistorial(int $pedidoId, string $estado, int $usuarioId): void
    {
        Database::ejecutar(
            'INSERT INTO historial_estados (pedido_id, estado, usuario_id) VALUES (?, ?, ?)',
            [$pedidoId, $estado, $usuarioId]
        );
    }

    private static function validarDireccion(array $datos): ?array
    {
        $calle = Validator::texto($datos['calle'] ?? '', 3, 150);
        $colonia = Validator::texto($datos['colonia'] ?? '', 2, 100);
        $cp = Validator::codigoPostal($datos['codigo_postal'] ?? '');
        $ciudad = Validator::texto($datos['ciudad'] ?? '', 2, 100);
        $estado = Validator::texto($datos['estado'] ?? '', 2, 100);

        if ($calle === null || $colonia === null || $cp === null || $ciudad === null || $estado === null) {
            return null;
        }

        return [
            $calle,
            Validator::texto($datos['numero_ext'] ?? '', 0, 20) ?? null,
            $colonia,
            $cp,
            $ciudad,
            $estado,
            Validator::texto($datos['referencia'] ?? '', 0, 200) ?? null,
        ];
    }
}
