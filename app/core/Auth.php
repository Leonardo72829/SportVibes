<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

/** Gestión de sesión, autenticación y control por roles. */
final class Auth
{
    public static function iniciarSesion(int $usuarioId): void
    {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuarioId;
    }

    public static function cerrarSesion(): void
    {
        unset($_SESSION['usuario_id']);
        session_regenerate_id(true);
    }

    public static function id(): ?int
    {
        return isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;
    }

    public static function usuario(): ?array
    {
        if (self::id() === null) {
            return null;
        }
        return Database::uno(
            'SELECT u.*, r.nombre AS rol FROM usuarios u JOIN roles r ON r.id = u.rol_id WHERE u.id = ?',
            [self::id()]
        );
    }

    public static function rol(): ?string
    {
        $usuario = self::usuario();
        return $usuario['rol'] ?? null;
    }

    public static function requerirLogin(): void
    {
        if (self::id() === null) {
            flash('error', 'Inicia sesión para continuar.');
            redirect('login');
        }
    }

    public static function requerirRol(array $roles): void
    {
        self::requerirLogin();
        if (!in_array(self::rol(), $roles, true)) {
            http_response_code(403);
            flash('error', 'No tienes permiso para acceder a esa sección.');
            redirect('');
        }
    }
}
