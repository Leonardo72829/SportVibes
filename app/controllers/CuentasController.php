<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Auth.php';

/** RF-01 y RF-02: registro e inicio de sesión. */
final class CuentasController
{
    public static function registroForm(): void
    {
        View::render('registro', [], 'Crear cuenta');
    }

    public static function registrar(): void
    {
        requerirPost();
        validarCsrf();

        $nombre = Validator::texto($_POST['nombre'] ?? '', 2, 100);
        $correo = Validator::correo($_POST['correo'] ?? '');
        $clave = (string) ($_POST['clave'] ?? '');
        $confirmacion = (string) ($_POST['confirmacion'] ?? '');

        guardarOld(['nombre' => (string) ($_POST['nombre'] ?? ''), 'correo' => (string) ($_POST['correo'] ?? '')]);

        if ($nombre === null || $correo === null) {
            flash('error', 'Revisa tu nombre y correo electrónico.');
            redirect('registro');
        }
        if (mb_strlen($clave) < 8 || $clave !== $confirmacion) {
            flash('error', 'La contraseña debe tener al menos 8 caracteres y coincidir con la confirmación.');
            redirect('registro');
        }
        if (Database::uno('SELECT id FROM usuarios WHERE correo = ?', [$correo])) {
            flash('error', 'Ese correo ya está registrado. Inicia sesión o usa otro correo.');
            redirect('registro');
        }

        Database::ejecutar(
            'INSERT INTO usuarios (rol_id, nombre, correo, contrasena_hash, activo) VALUES (?, ?, ?, ?, 1)',
            [1, $nombre, $correo, password_hash($clave, PASSWORD_DEFAULT)]
        );

        limpiarOld();
        Auth::iniciarSesion((int) Database::obtenerConexion()->lastInsertId());
        flash('exito', '¡Bienvenido a SportVibes! Tu cuenta está lista.');
        redirect('');
    }

    public static function loginForm(): void
    {
        View::render('login', [], 'Iniciar sesión');
    }

    public static function login(): void
    {
        requerirPost();
        validarCsrf();

        $correo = Validator::correo($_POST['correo'] ?? '');
        $clave = (string) ($_POST['clave'] ?? '');
        guardarOld(['correo' => (string) ($_POST['correo'] ?? '')]);

        $usuario = $correo === null
            ? null
            : Database::uno('SELECT * FROM usuarios WHERE correo = ?', [$correo]);

        if ($usuario === null || !password_verify($clave, (string) $usuario['contrasena_hash'])) {
            flash('error', 'Correo o contraseña incorrectos.');
            redirect('login');
        }
        if ((int) $usuario['activo'] !== 1) {
            flash('error', 'Esta cuenta está desactivada. Contacta al administrador.');
            redirect('login');
        }

        limpiarOld();
        Auth::iniciarSesion((int) $usuario['id']);
        flash('exito', 'Hola de nuevo, ' . $usuario['nombre'] . '.');
        redirect('');
    }

    public static function logout(): void
    {
        requerirPost();
        validarCsrf();
        Auth::cerrarSesion();
        flash('exito', 'Cerraste sesión correctamente.');
        redirect('');
    }
}
