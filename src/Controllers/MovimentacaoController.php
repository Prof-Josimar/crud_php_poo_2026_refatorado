<?php

namespace App\Controllers;

use App\Core\View;
use App\DAO\MovimentacaoDAO;
use App\DAO\PessoaDAO;
use App\Models\Movimentacao;

class MovimentacaoController
{
    private const TIPOS = [
        'credito' => ['titulo' => 'Depositar', 'observacao' => 'Depósito via sistema'],
        'debito'  => ['titulo' => 'Sacar',     'observacao' => 'Saque via sistema'],
    ];

    public function __construct(
        private MovimentacaoDAO $movDAO = new MovimentacaoDAO(),
        private PessoaDAO $pessoaDAO = new PessoaDAO()
    ) {
    }

    // GET /movimentacoes
    public function index(): void
    {
        View::render('movimentacoes/listar', ['movs' => $this->movDAO->findAll()]);
    }

    // GET /movimentacoes/nova?nome=ana   (procura a pessoa e oferece Depositar/Sacar/Transferir)
    public function nova(): void
    {
        $termo   = trim($_GET['nome'] ?? '');
        $buscou  = $termo !== '';
        $pessoas = $buscou ? $this->pessoaDAO->findByNome($termo) : [];

        View::render('movimentacoes/nova', compact('termo', 'buscou', 'pessoas'));
    }

    // GET /movimentacoes/extrato/{id}
    public function extrato(string $id): void
    {
        $pessoa = $this->pessoaOu404($id);

        View::render('movimentacoes/extrato', [
            'pessoa' => $pessoa,
            'saldo'  => $this->movDAO->getSaldo((int) $pessoa['id']),
            'movs'   => $this->movDAO->findByPessoa((int) $pessoa['id']),
        ]);
    }

    // GET /movimentacoes/saldos
    public function saldos(): void
    {
        View::render('movimentacoes/saldos', [
            'titulo'  => 'Saldos por Pessoa',
            'resumos' => $this->movDAO->getSaldos(),
        ]);
    }

    // GET /movimentacoes/saldos-positivos
    public function saldosPositivos(): void
    {
        View::render('movimentacoes/saldos', [
            'titulo'  => 'Saldos Positivos',
            'resumos' => $this->movDAO->getSaldos(somentePositivos: true),
        ]);
    }

    // ---------- Depósito / Saque ----------

    // GET /movimentacoes/{credito|debito}/{id}
    public function formulario(string $tipo, string $id): void
    {
        $this->tipoOu404($tipo);
        $this->formMovimentacao($tipo, $this->pessoaOu404($id));
    }

    // POST /movimentacoes/{credito|debito}/{id}
    public function registrar(string $tipo, string $id): void
    {
        $config = $this->tipoOu404($tipo);
        $pessoa = $this->pessoaOu404($id);
        $valor  = (float) str_replace(',', '.', $_POST['valor'] ?? '0');
        $obs    = trim($_POST['observacao'] ?? '') ?: $config['observacao'];

        $erro = null;
        if ($valor <= 0) {
            $erro = 'Informe um valor maior que zero.';
        } elseif ($tipo === 'debito' && $valor > $this->movDAO->getSaldo((int) $pessoa['id'])) {
            $erro = 'Saldo insuficiente para este saque.';
        }

        if ($erro) {
            $this->formMovimentacao($tipo, $pessoa, $erro);
            return;
        }

        $this->movDAO->insert(new Movimentacao(
            (int) $pessoa['id'],
            $tipo === 'credito' ? $valor : 0.00,
            $tipo === 'debito'  ? $valor : 0.00,
            $obs
        ));

        flash('success', 'Movimentação registrada com sucesso!');
        redirect('/movimentacoes/extrato/' . $pessoa['id']);
    }

    // ---------- Transferência ----------

    // GET /transferencias/{origem}?nome=...   (escolher o destinatário)
    public function transferenciaBuscar(string $origem): void
    {
        $pessoaOrigem = $this->pessoaOu404($origem);
        $termo        = trim($_GET['nome'] ?? '');
        $buscou       = $termo !== '';

        // não permite transferir para si mesmo
        $pessoas = array_filter(
            $buscou ? $this->pessoaDAO->findByNome($termo) : [],
            fn (array $p) => $p['id'] != $pessoaOrigem['id']
        );

        View::render('movimentacoes/transferir-buscar', [
            'origem' => $pessoaOrigem, 'termo' => $termo, 'buscou' => $buscou, 'pessoas' => $pessoas,
        ]);
    }

    // GET /transferencias/{origem}/{destino}
    public function transferenciaFormulario(string $origem, string $destino): void
    {
        [$o, $d] = $this->origemDestino($origem, $destino);
        $this->formTransferencia($o, $d);
    }

    // POST /transferencias/{origem}/{destino}
    public function transferir(string $origem, string $destino): void
    {
        [$o, $d] = $this->origemDestino($origem, $destino);
        $valor = (float) str_replace(',', '.', $_POST['valor'] ?? '0');

        $erro = null;
        if ($valor <= 0) {
            $erro = 'Informe um valor maior que zero.';
        } elseif ($valor > $this->movDAO->getSaldo((int) $o['id'])) {
            $erro = 'Saldo insuficiente para esta transferência.';
        }

        if ($erro) {
            $this->formTransferencia($o, $d, $erro);
            return;
        }

        // Nomes vêm do banco, não do formulário (o navegador não pode inventar nome).
        $this->movDAO->transferir((int) $o['id'], $o['nome'], (int) $d['id'], $d['nome'], $valor);

        flash('success', 'Transferência realizada com sucesso!');
        redirect('/movimentacoes/extrato/' . $o['id']);
    }

    // ---------- privados ----------

    private function pessoaOu404(string $id): array
    {
        return $this->pessoaDAO->findById((int) $id) ?? abort(404, 'Pessoa não encontrada.');
    }

    private function tipoOu404(string $tipo): array
    {
        return self::TIPOS[$tipo] ?? abort(404);
    }

    /** @return array{0: array, 1: array} */
    private function origemDestino(string $origem, string $destino): array
    {
        if ($origem === $destino) {
            abort(422, 'Origem e destino não podem ser a mesma pessoa.');
        }
        return [$this->pessoaOu404($origem), $this->pessoaOu404($destino)];
    }

    private function formMovimentacao(string $tipo, array $pessoa, ?string $erro = null): void
    {
        if ($erro) {
            http_response_code(422);
        }
        View::render('movimentacoes/form', [
            'tipo' => $tipo, 'config' => self::TIPOS[$tipo], 'pessoa' => $pessoa, 'destino' => null,
            'acao' => "/movimentacoes/{$tipo}/{$pessoa['id']}",
            'observacao' => $_POST['observacao'] ?? self::TIPOS[$tipo]['observacao'],
            'erro' => $erro,
        ]);
    }

    private function formTransferencia(array $origem, array $destino, ?string $erro = null): void
    {
        if ($erro) {
            http_response_code(422);
        }
        View::render('movimentacoes/form', [
            'tipo' => 'transferencia',
            'config' => ['titulo' => 'Transferir'],
            'pessoa' => $origem, 'destino' => $destino,
            'acao' => "/transferencias/{$origem['id']}/{$destino['id']}",
            'observacao' => null,
            'erro' => $erro,
        ]);
    }
}
