<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PhpMailerException;

/**
 * Notificaciones por correo (RF-14 y RF-22).
 * Cada aviso se guarda en la tabla notificaciones y, si hay SMTP configurado,
 * también se envía por correo real con PHPMailer.
 */
final class Mailer
{
    public static function enviar(
        string $destinatario,
        string $nombre,
        string $asunto,
        string $mensaje,
        string $tipo = 'confirmacion',
        ?int $pedidoId = null
    ): bool {
        Database::ejecutar(
            'INSERT INTO notificaciones (usuario_id, pedido_id, tipo, asunto, mensaje) VALUES (?, ?, ?, ?, ?)',
            [self::idPorCorreo($destinatario), $pedidoId, $tipo, $asunto, $mensaje]
        );

        if (SMTP_HOST === '') {
            // Sin SMTP configurado: modo local. El mensaje queda en storage/correos/
            // y también en la tabla notificaciones, visible en la sección «Avisos».
            $archivo = CorreoLocal::guardar($destinatario, $nombre, $asunto, $mensaje);
            error_log('SportVibes: correo capturado en storage/correos/' . $archivo);
            return false;
        }

        try {
            $correo = new PHPMailer(true);
            $correo->isSMTP();
            $correo->Host = SMTP_HOST;
            $correo->Port = SMTP_PORT;
            $correo->SMTPAuth = SMTP_USUARIO !== '';
            $correo->Username = SMTP_USUARIO;
            $correo->Password = SMTP_CLAVE;
            $correo->SMTPSecure = match (SMTP_SEGURIDAD) {
                'ssl' => PHPMailer::ENCRYPTION_SMTPS,
                'tls' => PHPMailer::ENCRYPTION_STARTTLS,
                default => '',
            };
            $correo->CharSet = 'UTF-8';
            $correo->setFrom(SMTP_FROM, SMTP_FROM_NOMBRE);
            $correo->addAddress($destinatario, $nombre);
            $correo->Subject = $asunto;
            $correo->Body = $mensaje;
            $correo->AltBody = strip_tags($mensaje);
            $correo->send();
            return true;
        } catch (PhpMailerException $error) {
            error_log('Error SMTP SportVibes: ' . $error->getMessage());
            return false;
        }
    }

    private static function idPorCorreo(string $correo): ?int
    {
        $usuario = Database::uno('SELECT id FROM usuarios WHERE correo = ?', [$correo]);
        return $usuario ? (int) $usuario['id'] : null;
    }
}
