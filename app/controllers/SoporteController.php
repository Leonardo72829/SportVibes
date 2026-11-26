<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Mailer.php';

/** RF-21 y RF-22: atención y respuesta de consultas. */
final class SoporteController
{
    public static function index(): void
    {
        Auth::requerirRol(['soporte']);
        View::render('soporte', [
            'consultas' => Database::todos(
                'SELECT c.*, u.nombre AS cliente, u.correo,
                        (SELECT COUNT(*) FROM consulta_respuestas r WHERE r.consulta_id = c.id) AS respuestas
                 FROM consultas c JOIN usuarios u ON u.id = c.usuario_id
                 ORDER BY c.atendida ASC, c.id DESC'
            ),
        ], 'Soporte');
    }

    public static function detalle(array $parametros): void
    {
        Auth::requerirRol(['soporte']);
        $id = Validator::entero($parametros[0] ?? null, 1);
        $consulta = $id === null ? null : Database::uno(
            'SELECT c.*, u.nombre AS cliente, u.correo, p.numero_pedido
             FROM consultas c
             JOIN usuarios u ON u.id = c.usuario_id
             LEFT JOIN pedidos p ON p.id = c.pedido_id
             WHERE c.id = ?',
            [$id]
        );

        if ($consulta === null) {
            http_response_code(404);
            View::render('404', [], 'Consulta no encontrada');
            return;
        }

        View::render('soporte_detalle', [
            'consulta' => $consulta,
            'respuestas' => Database::todos(
                'SELECT r.*, u.nombre AS autor FROM consulta_respuestas r
                 JOIN usuarios u ON u.id = r.usuario_id
                 WHERE r.consulta_id = ? ORDER BY r.id',
                [$id]
            ),
        ], 'Consulta ' . $consulta['folio']);
    }

    public static function responder(array $parametros): void
    {
        Auth::requerirRol(['soporte']);
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        $mensaje = Validator::texto($_POST['mensaje'] ?? '', 5, 2000);
        $consulta = $id === null ? null : Database::uno(
            'SELECT c.*, u.nombre AS cliente, u.correo FROM consultas c
             JOIN usuarios u ON u.id = c.usuario_id WHERE c.id = ?',
            [$id]
        );

        if ($consulta === null || $mensaje === null) {
            flash('error', 'Escribe una respuesta de al menos 5 caracteres.');
            redirect('soporte');
        }

        Database::ejecutar(
            'INSERT INTO consulta_respuestas (consulta_id, usuario_id, mensaje) VALUES (?, ?, ?)',
            [$id, (int) Auth::id(), $mensaje]
        );
        Database::ejecutar('UPDATE consultas SET atendida = 1 WHERE id = ?', [$id]);

        Mailer::enviar(
            (string) $consulta['correo'],
            (string) $consulta['cliente'],
            'Respuesta a tu consulta ' . $consulta['folio'],
            '<p>Hola ' . e($consulta['cliente']) . ':</p><p>Tu consulta <strong>' .
            e($consulta['folio']) . '</strong> fue respondida:</p><p>' . nl2br(e($mensaje)) . '</p>',
            'respuesta_soporte',
            $consulta['pedido_id'] !== null ? (int) $consulta['pedido_id'] : null
        );

        flash('exito', 'Respuesta enviada al cliente por correo.');
        redirect('soporte/' . $id);
    }
}
