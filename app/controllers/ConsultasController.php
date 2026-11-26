<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-20: consultas de clientes sobre sus pedidos. */
final class ConsultasController
{
    public static function index(): void
    {
        Auth::requerirLogin();
        $consultas = Database::todos(
            'SELECT c.*, (SELECT COUNT(*) FROM consulta_respuestas r WHERE r.consulta_id = c.id) AS respuestas
             FROM consultas c WHERE c.usuario_id = ? ORDER BY c.id DESC',
            [(int) Auth::id()]
        );
        View::render('consultas', ['consultas' => $consultas], 'Mis consultas');
    }

    public static function crear(): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $mensaje = Validator::texto($_POST['mensaje'] ?? '', 10, 2000);
        $pedidoId = Validator::entero($_POST['pedido_id'] ?? null, 1);

        if ($mensaje === null) {
            flash('error', 'Escribe una consulta de al menos 10 caracteres.');
            redirect('consultas');
        }
        if ($pedidoId !== null) {
            $existe = Database::uno(
                'SELECT id FROM pedidos WHERE id = ? AND usuario_id = ?',
                [$pedidoId, (int) Auth::id()]
            );
            if ($existe === null) {
                $pedidoId = null;
            }
        }

        $folio = 'C-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        Database::ejecutar(
            'INSERT INTO consultas (folio, pedido_id, usuario_id, mensaje) VALUES (?, ?, ?, ?)',
            [$folio, $pedidoId, (int) Auth::id(), $mensaje]
        );

        flash('exito', 'Consulta enviada con folio ' . $folio);
        redirect('consultas');
    }

    public static function detalle(array $parametros): void
    {
        Auth::requerirLogin();
        $id = Validator::entero($parametros[0] ?? null, 1);
        $consulta = $id === null ? null : Database::uno(
            'SELECT * FROM consultas WHERE id = ? AND usuario_id = ?',
            [$id, (int) Auth::id()]
        );

        if ($consulta === null) {
            http_response_code(404);
            View::render('404', [], 'Consulta no encontrada');
            return;
        }

        View::render('consulta_detalle', [
            'consulta' => $consulta,
            'respuestas' => Database::todos(
                'SELECT r.*, u.nombre AS autor FROM consulta_respuestas r
                 JOIN usuarios u ON u.id = r.usuario_id
                 WHERE r.consulta_id = ? ORDER BY r.id',
                [$id]
            ),
        ], 'Consulta ' . $consulta['folio']);
    }
}
