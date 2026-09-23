<?php

namespace App\Config;

use PDO;
use PDOException;

/**
 * Única fonte de conexão com o banco (substitui as antigas App\Database e App\Config\DB).
 * A conexão é criada uma vez e reaproveitada por todos os DAOs.
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $c = config('db');
        $dsn = "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}";

        try {
            self::$pdo = new PDO($dsn, $c['user'], $c['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log('Erro de conexão: ' . $e->getMessage());
            throw new PDOException('Não foi possível conectar ao banco de dados. Verifique config/config.php.');
        }

        return self::$pdo;
    }
}
