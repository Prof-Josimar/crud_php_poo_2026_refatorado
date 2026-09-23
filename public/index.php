<?php

// Front controller: TODA requisição entra por aqui.
// É o único .php que o navegador enxerga (document root = pasta public/).

// Servidor embutido do PHP (php -S): deixa servir css/js/imagens direto.
if (PHP_SAPI === 'cli-server') {
    $arquivo = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($arquivo)) {
        return false;
    }
}

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\View;

session_start();

$router = new Router();
require dirname(__DIR__) . '/config/routes.php';

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    error_log($e);
    http_response_code(500);
    View::render('erros/erro', [
        'titulo'   => 'Erro interno',
        'mensagem' => config('debug') ? $e->getMessage() : 'Ocorreu um erro inesperado. Tente novamente.',
    ]);
}
