<?php
declare(strict_types=1);

/** Pasarela simulada: no guarda datos de tarjeta ni se conecta a servicios externos. */
final class PagoSimulado
{
    public static function procesar(float $monto, string $resultado): array
    {
        $aprobado = $resultado === 'aprobado';

        return [
            'aprobado' => $aprobado,
            'referencia' => 'MOCK-' . strtoupper(bin2hex(random_bytes(6))),
            'monto' => $monto,
            'mensaje' => $aprobado
                ? 'Pago aprobado por la pasarela simulada.'
                : 'Pago rechazado por la pasarela simulada.',
        ];
    }
}
