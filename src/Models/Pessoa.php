<?php

namespace App\Models;

use App\Utils\Formatter;

class Pessoa
{
    private ?int $id = null;
    private string $nome = '';
    private ?string $telefone = null;
    private string $cpf = '';
    private ?string $endereco = null;

    // Passa pelos setters, então a normalização (maiúsculas, só dígitos) fica num lugar só.
    public function __construct(
        string $nome = '',
        ?string $telefone = null,
        string $cpf = '',
        ?string $endereco = null
    ) {
        $this->setNome($nome);
        $this->setTelefone($telefone);
        $this->setCpf($cpf);
        $this->setEndereco($endereco);
    }

    // ---------- Getters ----------
    public function getId(): ?int          { return $this->id; }
    public function getNome(): string      { return $this->nome; }
    public function getTelefone(): ?string { return $this->telefone; }
    public function getCpf(): string       { return $this->cpf; }
    public function getEndereco(): ?string { return $this->endereco; }

    public function getCpfFormatado(): string
    {
        return Formatter::formatCpf($this->cpf);
    }

    // ---------- Setters ----------
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNome(string $nome): void
    {
        $this->nome = Formatter::toUpper($nome);
    }

    public function setTelefone(?string $telefone): void
    {
        $this->telefone = Formatter::soDigitos($telefone);
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = (string) Formatter::soDigitos($cpf);
    }

    public function setEndereco(?string $endereco): void
    {
        $endereco = Formatter::toUpper($endereco);
        $this->endereco = $endereco === '' ? null : $endereco;
    }
}
