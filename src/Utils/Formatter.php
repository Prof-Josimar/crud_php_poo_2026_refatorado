<?php

namespace App\Utils;

class Formatter
{
    public static function formatCpf(?string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', (string) $cpf);

        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' .
                   substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf;
    }

    public static function formatTelefone(?string $telefone): string
    {
        $telefone = preg_replace('/\D/', '', (string) $telefone);

        return match (strlen($telefone)) {
            11      => sprintf('(%s) %s-%s', substr($telefone, 0, 2), substr($telefone, 2, 5), substr($telefone, 7)),
            10      => sprintf('(%s) %s-%s', substr($telefone, 0, 2), substr($telefone, 2, 4), substr($telefone, 6)),
            default => $telefone,
        };
    }

    /** Só dígitos (ou null se ficar vazio). */
    public static function soDigitos(?string $texto): ?string
    {
        $digitos = preg_replace('/\D/', '', (string) $texto);
        return $digitos === '' ? null : $digitos;
    }

    public static function toUpper(?string $texto): string
    {
        return mb_strtoupper(trim((string) $texto), 'UTF-8');
    }
}
