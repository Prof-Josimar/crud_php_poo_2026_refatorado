<?php

use App\Controllers\FakerController;
use App\Controllers\HomeController;
use App\Controllers\MovimentacaoController;
use App\Controllers\PessoaController;

/** @var App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

// ---------- Pessoas ----------
$router->get('/pessoas',                 [PessoaController::class, 'index']);
$router->get('/pessoas/pesquisar',       [PessoaController::class, 'pesquisar']);
$router->get('/pessoas/novo',            [PessoaController::class, 'create']);
$router->post('/pessoas',                [PessoaController::class, 'store']);
$router->get('/pessoas/excluir-todas',   [PessoaController::class, 'confirmarExcluirTodas']);
$router->post('/pessoas/excluir-todas',  [PessoaController::class, 'excluirTodas']);
$router->get('/pessoas/{id}',            [PessoaController::class, 'show']);
$router->get('/pessoas/{id}/editar',     [PessoaController::class, 'edit']);
$router->post('/pessoas/{id}/editar',    [PessoaController::class, 'update']);
$router->post('/pessoas/{id}/excluir',   [PessoaController::class, 'destroy']);

// ---------- Movimentações ----------
$router->get('/movimentacoes',                    [MovimentacaoController::class, 'index']);
$router->get('/movimentacoes/nova',               [MovimentacaoController::class, 'nova']);
$router->get('/movimentacoes/saldos',             [MovimentacaoController::class, 'saldos']);
$router->get('/movimentacoes/saldos-positivos',   [MovimentacaoController::class, 'saldosPositivos']);
$router->get('/movimentacoes/extrato/{id}',       [MovimentacaoController::class, 'extrato']);
$router->get('/movimentacoes/{tipo}/{id}',        [MovimentacaoController::class, 'formulario']);  // credito | debito
$router->post('/movimentacoes/{tipo}/{id}',       [MovimentacaoController::class, 'registrar']);

// ---------- Transferências ----------
$router->get('/transferencias/{origem}',            [MovimentacaoController::class, 'transferenciaBuscar']);
$router->get('/transferencias/{origem}/{destino}',  [MovimentacaoController::class, 'transferenciaFormulario']);
$router->post('/transferencias/{origem}/{destino}', [MovimentacaoController::class, 'transferir']);

// ---------- Faker ----------
$router->get('/faker/pessoas',   [FakerController::class, 'pessoas']);
$router->post('/faker/pessoas',  [FakerController::class, 'gerarPessoas']);
$router->get('/faker/usuarios',  [FakerController::class, 'usuarios']);
$router->post('/faker/usuarios', [FakerController::class, 'gerarUsuarios']);
