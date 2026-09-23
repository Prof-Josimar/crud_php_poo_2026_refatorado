<?php

// Funções globais pequenas, usadas principalmente nas views.
// Carregado pelo Composer (autoload "files").

use App\Core\View;

/** Escapa texto para HTML (proteção contra XSS). Use em TODO dado vindo do usuário/banco. */
function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Lê config/config.php com notação de ponto: config('db.host'). */
function config(string $chave, mixed $padrao = null): mixed
{
    static $config = null;
    $config ??= require dirname(__DIR__) . '/config/config.php';

    $valor = $config;
    foreach (explode('.', $chave) as $parte) {
        if (!is_array($valor) || !array_key_exists($parte, $valor)) {
            return $padrao;
        }
        $valor = $valor[$parte];
    }
    return $valor;
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/** Interrompe a requisição mostrando uma página de erro. */
function abort(int $codigo, string $mensagem = 'Página não encontrada.'): never
{
    http_response_code($codigo);
    View::render('erros/erro', ['titulo' => "Erro $codigo", 'mensagem' => $mensagem]);
    exit;
}

/** Guarda uma mensagem para aparecer na PRÓXIMA página (padrão Post/Redirect/Get). */
function flash(string $tipo, string $mensagem): void
{
    $_SESSION['flash'][] = ['tipo' => $tipo, 'mensagem' => $mensagem];
}

function flash_pull(): array
{
    $mensagens = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $mensagens;
}

// ---------- CSRF ----------
function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_valido(): bool
{
    return hash_equals(csrf_token(), (string) ($_POST['_token'] ?? ''));
}

/** 1234.5 -> "1.234,50" */
function moeda(mixed $valor): string
{
    return number_format((float) $valor, 2, ',', '.');
}
