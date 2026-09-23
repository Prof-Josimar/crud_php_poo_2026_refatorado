<?php

namespace App\Controllers;

use App\Core\View;
use App\DAO\PessoaDAO;
use App\Models\Pessoa;
use App\Utils\Formatter;
use PDOException;

class PessoaController
{
    public function __construct(private PessoaDAO $dao = new PessoaDAO())
    {
    }

    // GET /pessoas?pagina=2
    public function index(): void
    {
        $limite       = (int) config('itens_por_pagina', 10);
        $total        = $this->dao->countAll();
        $totalPaginas = max(1, (int) ceil($total / $limite));
        $pagina       = min(max(1, (int) ($_GET['pagina'] ?? 1)), $totalPaginas);

        $pessoas = $this->dao->findAllPaginado($limite, ($pagina - 1) * $limite);

        View::render('pessoas/listar', compact('pessoas', 'pagina', 'totalPaginas', 'total'));
    }

    // GET /pessoas/pesquisar?nome=ana
    public function pesquisar(): void
    {
        $termo   = trim($_GET['nome'] ?? '');
        $buscou  = $termo !== '';
        $pessoas = $buscou ? $this->dao->findByNome($termo) : [];

        View::render('pessoas/pesquisar', compact('termo', 'buscou', 'pessoas'));
    }

    // GET /pessoas/{id}
    public function show(string $id): void
    {
        View::render('pessoas/detalhes', ['pessoa' => $this->buscarOu404($id)]);
    }

    // GET /pessoas/novo
    public function create(): void
    {
        $this->formulario(
            titulo: 'Cadastrar Pessoa',
            acao: '/pessoas',
            pessoa: ['nome' => '', 'telefone' => '', 'cpf' => '', 'endereco' => ''],
        );
    }

    // POST /pessoas
    public function store(): void
    {
        [$erros, $dados] = $this->validar($_POST);

        if (!$erros) {
            try {
                $this->dao->insert(new Pessoa($dados['nome'], $dados['telefone'], $dados['cpf'], $dados['endereco']));
                flash('success', 'Pessoa cadastrada com sucesso!');
                redirect('/pessoas');
            } catch (PDOException $e) {
                $erros[] = $this->mensagemDeErro($e);
            }
        }

        $this->formulario('Cadastrar Pessoa', '/pessoas', $dados, $erros);
    }

    // GET /pessoas/{id}/editar
    public function edit(string $id): void
    {
        $pessoa = $this->buscarOu404($id);
        $this->formulario('Editar Pessoa', "/pessoas/{$pessoa['id']}/editar", $pessoa);
    }

    // POST /pessoas/{id}/editar
    public function update(string $id): void
    {
        $atual = $this->buscarOu404($id);
        [$erros, $dados] = $this->validar($_POST);

        if (!$erros) {
            $pessoa = new Pessoa($dados['nome'], $dados['telefone'], $dados['cpf'], $dados['endereco']);
            $pessoa->setId((int) $atual['id']);

            try {
                $this->dao->update($pessoa);
                flash('success', 'Dados atualizados com sucesso!');
                redirect('/pessoas');
            } catch (PDOException $e) {
                $erros[] = $this->mensagemDeErro($e);
            }
        }

        $this->formulario('Editar Pessoa', "/pessoas/{$atual['id']}/editar", $dados, $erros);
    }

    // POST /pessoas/{id}/excluir
    public function destroy(string $id): void
    {
        $pessoa = $this->buscarOu404($id);

        try {
            $this->dao->delete((int) $pessoa['id']);
            flash('success', 'Pessoa excluída com sucesso!');
        } catch (PDOException $e) {
            // FK: pessoa com movimentações não pode ser apagada
            flash('danger', $e->getCode() === '23000'
                ? 'Não é possível excluir: esta pessoa possui movimentações.'
                : 'Erro ao excluir pessoa.');
        }

        redirect('/pessoas');
    }

    // GET /pessoas/excluir-todas
    public function confirmarExcluirTodas(): void
    {
        $a = random_int(1, 10);
        $b = random_int(1, 10);
        $_SESSION['desafio_soma'] = $a + $b;

        View::render('pessoas/excluir-todas', ['desafio' => "$a + $b"]);
    }

    // POST /pessoas/excluir-todas
    public function excluirTodas(): void
    {
        $esperado = $_SESSION['desafio_soma'] ?? null;
        unset($_SESSION['desafio_soma']);   // desafio vale uma vez só

        if ($esperado === null || (int) ($_POST['resposta'] ?? -1) !== $esperado) {
            flash('danger', 'Desafio incorreto! Exclusão não realizada.');
            redirect('/pessoas');
        }

        $this->dao->deleteAll();
        flash('success', 'Todos os registros foram excluídos com sucesso!');
        redirect('/pessoas');
    }

    // ---------- privados ----------

    private function buscarOu404(string $id): array
    {
        return $this->dao->findById((int) $id) ?? abort(404, 'Pessoa não encontrada.');
    }

    private function formulario(string $titulo, string $acao, array $pessoa, array $erros = []): void
    {
        if ($erros) {
            http_response_code(422);
        }
        View::render('pessoas/form', compact('titulo', 'acao', 'pessoa', 'erros'));
    }

    /** @return array{0: string[], 1: array<string, ?string>} [erros, dados normalizados] */
    private function validar(array $entrada): array
    {
        $dados = [
            'nome'     => trim($entrada['nome'] ?? ''),
            'telefone' => Formatter::soDigitos($entrada['telefone'] ?? ''),
            'cpf'      => (string) Formatter::soDigitos($entrada['cpf'] ?? ''),
            'endereco' => trim($entrada['endereco'] ?? ''),
        ];

        $erros = [];
        if ($dados['nome'] === '' || mb_strlen($dados['nome']) > 100) {
            $erros[] = 'Informe o nome (até 100 caracteres).';
        }
        if (strlen($dados['cpf']) !== 11) {
            $erros[] = 'O CPF deve ter 11 dígitos.';
        }
        if ($dados['telefone'] !== null && strlen($dados['telefone']) > 15) {
            $erros[] = 'Telefone com dígitos demais (máximo 15).';
        }
        if (mb_strlen($dados['endereco']) > 255) {
            $erros[] = 'Endereço muito longo (máximo 255 caracteres).';
        }

        return [$erros, $dados];
    }

    private function mensagemDeErro(PDOException $e): string
    {
        if ($e->getCode() === '23000') {           // violação de UNIQUE (cpf)
            return 'Já existe uma pessoa cadastrada com este CPF.';
        }
        throw $e;                                   // outro erro: deixa subir para o index.php
    }
}
