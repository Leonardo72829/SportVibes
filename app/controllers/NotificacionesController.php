<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-14 y RF-22: bandeja de notificaciones del usuario. */
final class NotificacionesController
{
    public static function index(): void
    {
        Auth::requerirLogin();
        View::render('notificaciones', [
            'notificaciones' => Database::todos(
                'SELECT * FROM notificaciones WHERE usuario_id = ? ORDER BY id DESC',
                [(int) Auth::id()]
            ),
        ], 'Notificaciones');
    }

    public static function marcarLeida(array $parametros): void
    {
        Auth::requerirLogin();
        requerirPost();
        validarCsrf();

        $id = Validator::entero($parametros[0] ?? null, 1);
        if ($id !== null) {
            Database::ejecutar(
                'UPDATE notificaciones SET leida = 1 WHERE id = ? AND usuario_id = ?',
                [$id, (int) Auth::id()]
            );
        }
        redirect('notificaciones');
    }
}
