<?php

// Configurações da aplicação.
// Dá para sobrescrever pelo ambiente (DB_HOST, DB_NAME, DB_USER, DB_PASS)
// sem mexer neste arquivo — útil para não versionar senha.
return [
    'debug' => true, // em produção: false (não mostra mensagens técnicas)

    'db' => [
        'host'    => getenv('DB_HOST') ?: 'localhost',
        'name'    => getenv('DB_NAME') ?: 'aulapdo',
        'user'    => getenv('DB_USER') ?: 'root',
        'pass'    => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],

    'itens_por_pagina' => 10,
];
