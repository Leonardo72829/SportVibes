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

/**
 * Imagen del producto. Si hay foto real en `public/assets/img/`, la muestra con
 * una etiqueta LOCAL/VISITANTE; en Esports (variante 'unica') no lleva etiqueta
 * porque solo existe una playera. Si no hay foto, genera un SVG con el mismo diseño.
 * En todos los casos se mantiene el mismo encuadre.
 */
function imagen_producto(array $producto): string
{
    $id = (int) ($producto['id'] ?? 0);
    $nombre = (string) ($producto['nombre'] ?? 'SportVibes');
    $texto = mb_strtolower($nombre . ' ' . (string) ($producto['descripcion'] ?? ''));

    // Si el producto trae la variante guardada, esa manda; si no, se deduce del nombre.
    $guardada = mb_strtolower((string) ($producto['variante'] ?? ''));
    $unica = str_contains($guardada, 'unica');
    $visitante = !$unica && ($guardada !== ''
        ? str_contains($guardada, 'visitante')
        : str_contains($texto, 'visitante') && !str_contains($texto, 'local'));
    $etiqueta = $unica ? '' : ($visitante ? 'VISITANTE' : 'LOCAL');

    $equipo = preg_replace('/^(camiseta|jersey)\s+/iu', '', $nombre) ?? $nombre;
    $equipo = preg_replace('/\s+(edici[oó]n\s+)?(local|visitante)\s*$/iu', '', $equipo) ?? $equipo;
    $equipo = mb_substr(trim($equipo), 0, 16);

    // Foto real del club: se guarda en productos.imagen y se sirve desde public/.
    $archivo = basename((string) ($producto['imagen'] ?? ''));
    if ($archivo !== '' && $archivo !== '.') {
        $ruta = dirname(__DIR__, 2) . '/public/assets/img/' . $archivo;
        if (is_file($ruta)) {
            $alt = $unica
                ? e('Jersey ' . $equipo)
                : e('Camiseta ' . $equipo . ', versión ' . strtolower($etiqueta));
            $html = '<span class="imagen-producto imagen-producto--foto">'
                . '<img src="' . e(url('assets/img/' . rawurlencode($archivo))) . '" alt="' . $alt . '" loading="lazy">';
            if ($etiqueta !== '') {
                $clase = $visitante ? 'visitante' : 'local';
                $html .= '<span class="etiqueta-variante etiqueta-variante--' . $clase . '">' . e($etiqueta) . '</span>';
            }
            return $html . '</span>';
        }
    }

    $paletas = [
        'américa' => ['#f5d20a', '#143b8c', '#ffffff'],
        'america' => ['#f5d20a', '#143b8c', '#ffffff'],
        'cruz azul' => ['#1646b8', '#0b1a3a', '#ffffff'],
        'liverpool' => ['#c8102e', '#0b1a3a', '#ffffff'],
        'bayern' => ['#d30b2f', '#0b1a3a', '#ffffff'],
        'psg' => ['#102a63', '#d10b3c', '#ffffff'],
        'inter' => ['#0068a8', '#0b1a3a', '#ffffff'],
        'flamengo' => ['#d90b1c', '#111318', '#ffffff'],
        'kings league' => ['#7c3aed', '#0b1020', '#ffffff'],
        'esports' => ['#00c8ff', '#0b1020', '#b6ff3c'],
    ];
    $colores = ['#b6ff3c', '#182238', '#0b1020'];
    foreach ($paletas as $clave => $paleta) {
        if (str_contains($texto, $clave)) {
            $colores = $paleta;
            break;
        }
    }

    // En visitante la camiseta es clara y la franja toma el color del equipo.
    $base = $visitante ? '#f2f5fb' : $colores[0];
    $franja = $visitante ? $colores[0] : $colores[1];
    // Elegir texto claro u oscuro según el fondo para que siempre se lea.
    $contraste = static function (string $hex): string {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return (0.299 * $r + 0.587 * $g + 0.114 * $b) > 150 ? '#0b1020' : '#ffffff';
    };
    $colorTexto = $contraste($base);
    $colorFranjaTexto = $contraste($franja);
    $colorEtiqueta = $visitante ? '#5aa0ff' : '#b6ff3c';
    $colorEtiquetaTexto = $visitante ? '#081226' : '#0d1408';
    $inicial = mb_substr($equipo, 0, 1);
    $tamanoEquipo = mb_strlen($equipo) > 12 ? 18 : 25;
    $clipId = 'jersey-' . $id;
    $forma = 'M150 70 L120 82 L86 130 L120 152 L136 132 L136 300 Q200 316 264 300 '
        . 'L264 132 L280 152 L314 130 L280 82 L250 70 Q236 92 200 92 Q164 92 150 70 Z';

    $equipoSeguro = e($equipo);
    $etiquetaSegura = e($etiqueta);
    $inicialSegura = e($inicial);
    $aria = $unica
        ? e('Jersey ' . $equipo)
        : e('Camiseta ' . $equipo . ', versión ' . strtolower($etiqueta));
    $bloqueEtiqueta = $unica ? '' : <<<SVG
  <rect x="126" y="292" width="148" height="28" rx="14" fill="{$colorEtiqueta}"/>
  <text x="200" y="311" text-anchor="middle" font-size="15" font-weight="800" letter-spacing="2" fill="{$colorEtiquetaTexto}">{$etiquetaSegura}</text>
SVG;

    return <<<SVG
<svg class="imagen-producto" viewBox="0 0 400 360" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{$aria}">
  <defs><clipPath id="{$clipId}"><path d="{$forma}"/></clipPath></defs>
  <rect width="400" height="360" rx="18" fill="#0e1628"/>
  <circle cx="200" cy="172" r="142" fill="{$franja}" opacity="0.10"/>
  <path d="{$forma}" fill="{$base}"/>
  <g clip-path="url(#{$clipId})">
    <rect x="120" y="156" width="160" height="38" fill="{$franja}" opacity="0.85"/>
    <rect x="120" y="274" width="160" height="9" fill="{$franja}" opacity="0.32"/>
  </g>
  <path d="{$forma}" fill="none" stroke="#ffffff" stroke-opacity="0.28" stroke-width="3"/>
  <circle cx="200" cy="127" r="17" fill="{$franja}" stroke="{$colorTexto}" stroke-width="2"/>
  <text x="200" y="134" text-anchor="middle" font-size="16" font-weight="800" fill="{$colorFranjaTexto}">{$inicialSegura}</text>
  <text x="200" y="226" text-anchor="middle" font-size="{$tamanoEquipo}" font-weight="900" fill="{$colorTexto}">{$equipoSeguro}</text>
{$bloqueEtiqueta}
</svg>
SVG;
}
