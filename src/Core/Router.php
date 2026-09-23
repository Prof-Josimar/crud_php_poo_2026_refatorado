<?php

namespace App\Core;

class Router
{
    /** @var array<string, array<int, array{0:string,1:array}>> */
    private array $rotas = [];

    public function get(string $caminho, array $handler): void
    {
        $this->add('GET', $caminho, $handler);
    }

    public function post(string $caminho, array $handler): void
    {
        $this->add('POST', $caminho, $handler);
    }

    private function add(string $metodo, string $caminho, array $handler): void
    {
        // "/pessoas/{id}/editar"  ->  #^/pessoas/(?P<id>[^/]+)/editar$#
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $caminho) . '$#';
        $this->rotas[$metodo][] = [$regex, $handler];
    }

    public function dispatch(string $metodo, string $uri): void
    {
        $caminho = rtrim((string) parse_url($uri, PHP_URL_PATH), '/') ?: '/';

        if ($metodo === 'POST' && !csrf_valido()) {
            abort(419, 'Sessão expirada ou formulário inválido. Volte e tente de novo.');
        }

        foreach ($this->rotas[$metodo] ?? [] as [$regex, $handler]) {
            if (preg_match($regex, $caminho, $m)) {
                // só os parâmetros nomeados ({id}, {tipo}...), na ordem em que aparecem
                $params = array_values(array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY));
                [$classe, $acao] = $handler;
                (new $classe())->$acao(...$params);
                return;
            }
        }

        abort(404);
    }
}
