<?php

namespace App\Controllers;

use App\Core\View;
use App\DAO\PessoaDAO;
use App\DAO\UsuarioDAO;
use App\Models\Pessoa;
use Faker\Factory;
use PDOException;

/** Dados de teste. Precisa do fakerphp/faker (composer install, com dev). */
class FakerController
{
    // GET /faker/pessoas
    public function pessoas(): void
    {
        View::render('faker/pessoas');
    }

    // POST /faker/pessoas
    public function gerarPessoas(): void
    {
        $this->exigirFaker();

        $quantidade = min(1000, max(1, (int) ($_POST['quantidade'] ?? 10)));
        $faker      = Factory::create('pt_BR');
        $dao        = new PessoaDAO();
        $sucesso    = 0;
        $erros      = 0;

        for ($i = 0; $i < $quantidade; $i++) {
            $pessoa = new Pessoa($faker->name(), $faker->phoneNumber(), $faker->cpf(false), $faker->address());

            try {
                $dao->insert($pessoa);
                $sucesso++;
            } catch (PDOException) {
                $erros++;      // CPF repetido, por exemplo
            }
        }

        flash('success', "$sucesso pessoa(s) cadastrada(s) com sucesso!");
        if ($erros) {
            flash('warning', "$erros registro(s) não puderam ser gravados.");
        }
        redirect('/pessoas');
    }

    // GET /faker/usuarios
    public function usuarios(): void
    {
        View::render('faker/usuarios', ['usuarios' => (new UsuarioDAO())->findAll()]);
    }

    // POST /faker/usuarios
    public function gerarUsuarios(): void
    {
        $this->exigirFaker();

        (new UsuarioDAO())->insertManyFake(10);
        flash('success', '10 usuários fake cadastrados.');
        redirect('/faker/usuarios');
    }

    private function exigirFaker(): void
    {
        if (!class_exists(Factory::class)) {
            abort(500, 'Faker não instalado. Rode: composer require --dev fakerphp/faker');
        }
    }
}
