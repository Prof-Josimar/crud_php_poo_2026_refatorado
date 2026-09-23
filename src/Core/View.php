<?php

namespace App\Core;

class View
{
    private const PASTA = __DIR__ . '/../../views';

    /** Renderiza views/<view>.php dentro do layout. */
    public static function render(string $view, array $dados = [], string $layout = 'layout'): void
    {
        ob_start();
        self::incluir($view, $dados);
        $content = ob_get_clean();          // HTML da página, usado pelo layout

        self::incluir($layout, $dados + ['content' => $content]);
    }

    /** Inclui um pedaço de view (tabela, paginação...) sem layout. */
    public static function partial(string $view, array $dados = []): void
    {
        self::incluir($view, $dados);
    }

    private static function incluir(string $view, array $dados): void
    {
        extract($dados, EXTR_SKIP);
        require self::PASTA . '/' . $view . '.php';
    }
}
