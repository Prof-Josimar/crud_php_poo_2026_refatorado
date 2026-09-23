<?php

// Uso: php bin/create_tables.php
// Cria as tabelas (se ainda não existirem) a partir de database/schema.sql.

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;

$pdo = Database::connection();
$sql = file_get_contents(__DIR__ . '/../database/schema.sql');

foreach (array_filter(array_map('trim', explode(';', $sql))) as $comando) {
    $pdo->exec($comando);
}

echo "Tabelas criadas/verificadas com sucesso!\n";
