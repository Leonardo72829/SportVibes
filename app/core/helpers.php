<?php
declare(strict_types=1);

/** Funciones auxiliares globales de SportVibes. */

function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function url(string $ruta = ''): string
{
    return APP_URL . '/' . ltrim($ruta, '/');
}

function redirect(string $ruta): never
{
    // Conserva códigos explícitos (403, 419, etc.) en lugar de sobrescribirlos con 302.
    $codigo = http_response_code();
    $codigo = ($codigo >= 300 && $codigo < 600) ? $codigo : 302;
    header('Location: ' . url($ruta), true, $codigo);
    exit;
}

function old(string $clave, string $porDefecto = ''): string
{
    return e($_SESSION['old'][$clave] ?? $porDefecto);
}

function guardarOld(array $datos): void
{
    $_SESSION['old'] = $datos;
}

function limpiarOld(): void
{
    unset($_SESSION['old']);
}

function flash(string $tipo, string $mensaje): void
{
    $_SESSION['flash'][] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}

function tomarFlashes(): array
{
    $mensajes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $mensajes;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function validarCsrf(): void
{
    $enviado = (string) ($_POST['csrf'] ?? '');
    if (!hash_equals(csrf_token(), $enviado)) {
        http_response_code(419);
        flash('error', 'La sesión expiró. Vuelve a intentarlo.');
        redirect($_SERVER['HTTP_REFERER'] ?? '');
    }
}

function requerirPost(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        http_response_code(405);
        exit('Método no permitido');
    }
}

function dinero(float $cantidad): string
{
    return '$' . number_format($cantidad, 2, '.', ',') . ' MXN';
}

function fecha(string $fecha): string
{
    $marca = strtotime($fecha);
    return $marca === false ? $fecha : date('d/m/Y H:i', $marca);
}

function estadoBadge(string $estado): string
{
    $etiquetas = [
        'pendiente' => 'Pendiente',
        'pagado' => 'Pagado',
        'en_preparacion' => 'En preparación',
        'enviado' => 'Enviado',
        'entregado' => 'Entregado',
        'cancelado' => 'Cancelado',
    ];
    $texto = $etiquetas[$estado] ?? ucfirst($estado);
    return '<span class="badge badge--' . e($estado) . '">' . e($texto) . '</span>';
}
