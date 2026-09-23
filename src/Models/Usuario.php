<?php

namespace App\Models;

class Usuario
{
    private ?int $id = null;
    private string $nome;
    private string $sobrenome;
    private string $email;
    private string $telefone;
    private string $endereco;
    private string $cidade;
    private string $cep;
    private string $empresa;
    private string $cargo;
    private string $dataNascimento;
    private string $numeroCartao;
    private string $iban;
    private string $uuid;

    // GETTERS
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getSobrenome(): string { return $this->sobrenome; }
    public function getEmail(): string { return $this->email; }
    public function getTelefone(): string { return $this->telefone; }
    public function getEndereco(): string { return $this->endereco; }
    public function getCidade(): string { return $this->cidade; }
    public function getCep(): string { return $this->cep; }
    public function getEmpresa(): string { return $this->empresa; }
    public function getCargo(): string { return $this->cargo; }
    public function getDataNascimento(): string { return $this->dataNascimento; }
    public function getNumeroCartao(): string { return $this->numeroCartao; }
    public function getIban(): string { return $this->iban; }
    public function getUuid(): string { return $this->uuid; }

    // SETTERS
    public function setId(int $id): void { $this->id = $id; }
    public function setNome(string $nome): void { $this->nome = $nome; }
    public function setSobrenome(string $sobrenome): void { $this->sobrenome = $sobrenome; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setTelefone(string $telefone): void { $this->telefone = $telefone; }
    public function setEndereco(string $endereco): void { $this->endereco = $endereco; }
    public function setCidade(string $cidade): void { $this->cidade = $cidade; }
    public function setCep(string $cep): void { $this->cep = $cep; }
    public function setEmpresa(string $empresa): void { $this->empresa = $empresa; }
    public function setCargo(string $cargo): void { $this->cargo = $cargo; }
    public function setDataNascimento(string $dataNascimento): void { $this->dataNascimento = $dataNascimento; }
    public function setNumeroCartao(string $numeroCartao): void { $this->numeroCartao = $numeroCartao; }
    public function setIban(string $iban): void { $this->iban = $iban; }
    public function setUuid(string $uuid): void { $this->uuid = $uuid; }
}
