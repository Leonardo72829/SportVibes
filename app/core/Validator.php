<?php
declare(strict_types=1);

/** Validaciones reutilizables de los formularios. */
final class Validator
{
    public static function texto(mixed $valor, int $min = 1, int $max = 255): ?string
    {
        $valor = trim((string) $valor);
        if (mb_strlen($valor) < $min || mb_strlen($valor) > $max) {
            return null;
        }
        return $valor;
    }

    public static function correo(mixed $valor): ?string
    {
        $valor = trim((string) $valor);
        return filter_var($valor, FILTER_VALIDATE_EMAIL) ?: null;
    }

    public static function entero(mixed $valor, int $min = 0, int $max = PHP_INT_MAX): ?int
    {
        if (!filter_var($valor, FILTER_VALIDATE_INT)) {
            return null;
        }
        $numero = (int) $valor;
        return ($numero >= $min && $numero <= $max) ? $numero : null;
    }

    public static function decimal(mixed $valor, float $min = 0): ?float
    {
        $valor = str_replace(',', '.', trim((string) $valor));
        if (!is_numeric($valor)) {
            return null;
        }
        $numero = (float) $valor;
        return $numero >= $min ? $numero : null;
    }

    public static function codigoPostal(mixed $valor): ?string
    {
        $valor = trim((string) $valor);
        return preg_match('/^\d{5}$/', $valor) ? $valor : null;
    }

    public static function palabraSegura(string $nombre): bool
    {
        $lista = ['idiota', 'estupido', 'imbecil', 'cretino', 'basura', 'perra', 'puto', 'gay', 'lesbiana', 'maricon', 'puta', 'cabrón', 'cabron', 'pendejo', 'weon', 'weón', 'concha', 'chinga', 'joto'];
        $normalizado = self::normalizar($nombre);
        foreach ($lista as $palabra) {
            if (str_contains($normalizado, self::normalizar($palabra))) {
                return false;
            }
        }
        return true;
    }

    private static function normalizar(string $texto): string
    {
        $texto = mb_strtolower($texto, 'UTF-8');
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'u'],
            $texto
        );
        return (string) preg_replace('/[^a-z0-9 ]/', '', $texto);
    }
}
