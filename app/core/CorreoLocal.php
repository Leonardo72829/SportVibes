<?php
declare(strict_types=1);

/**
 * Bandeja local de correos para desarrollo, sin credenciales ni instalaciones.
 * Cada mensaje se guarda como un archivo .eml que puede abrirse con cualquier
 * cliente de correo. Si se configura SMTP en .env, Mailer usa PHPMailer en vez de esto.
 */
final class CorreoLocal
{
    private static function carpeta(): string
    {
        $carpeta = BASE_PATH . '/storage/correos';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0775, true);
        }
        return $carpeta;
    }

    /** Guarda el correo y devuelve el nombre del archivo generado. */
    public static function guardar(
        string $destinatario,
        string $nombre,
        string $asunto,
        string $mensaje
    ): string {
        $archivo = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.eml';
        $contenido = implode("\r\n", [
            'From: ' . self::cabecera(SMTP_FROM_NOMBRE . ' <' . SMTP_FROM . '>'),
            'To: ' . self::cabecera($nombre . ' <' . $destinatario . '>'),
            'Subject: ' . self::cabecera($asunto),
            'Date: ' . date(DATE_RFC2822),
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'X-SportVibes-Modo: local',
            '',
            $mensaje,
            '',
        ]);

        file_put_contents(self::carpeta() . '/' . $archivo, $contenido, LOCK_EX);
        return $archivo;
    }

    /** Lista los correos capturados, del más reciente al más antiguo. */
    public static function listar(): array
    {
        $archivos = glob(self::carpeta() . '/*.eml') ?: [];
        rsort($archivos);

        $lista = [];
        foreach ($archivos as $ruta) {
            $lista[] = [
                'archivo' => basename($ruta),
                'fecha' => date('Y-m-d H:i:s', (int) filemtime($ruta)),
                'tamano' => (int) filesize($ruta),
            ];
        }
        return $lista;
    }

    /** Devuelve la ruta segura de un archivo, o null si el nombre no es válido. */
    public static function ruta(string $archivo): ?string
    {
        if (!preg_match('/^\d{8}_\d{6}_[0-9a-f]{8}\.eml$/', $archivo)) {
            return null;
        }
        $ruta = self::carpeta() . '/' . $archivo;
        return is_file($ruta) ? $ruta : null;
    }

    /** Evita inyección de cabeceras en los valores de From/To/Subject. */
    private static function cabecera(string $valor): string
    {
        return str_replace(["\r", "\n", '%0d', '%0a'], '', $valor);
    }
}
