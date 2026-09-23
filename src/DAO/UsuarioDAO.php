<?php

namespace App\DAO;

use App\Models\Usuario;
use App\Config\Database;
use PDO;
use PDOException;
use Faker\Factory;

class UsuarioDAO
{
    private PDO $conn;

    public function __construct(?PDO $conn = null)
    {
        $this->conn = $conn ?? Database::connection();
    }

    // INSERT normal
    public function insert(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios_faker 
            (nome, sobrenome, email, telefone, endereco, cidade, cep, empresa, cargo, data_nascimento, numero_cartao, iban, uuid) 
            VALUES 
            (:nome, :sobrenome, :email, :telefone, :endereco, :cidade, :cep, :empresa, :cargo, :data_nascimento, :numero_cartao, :iban, :uuid)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':sobrenome' => $usuario->getSobrenome(),
            ':email' => $usuario->getEmail(),
            ':telefone' => $usuario->getTelefone(),
            ':endereco' => $usuario->getEndereco(),
            ':cidade' => $usuario->getCidade(),
            ':cep' => $usuario->getCep(),
            ':empresa' => $usuario->getEmpresa(),
            ':cargo' => $usuario->getCargo(),
            ':data_nascimento' => $usuario->getDataNascimento(),
            ':numero_cartao' => $usuario->getNumeroCartao(),
            ':iban' => $usuario->getIban(),
            ':uuid' => $usuario->getUuid()
        ]);
    }

    // LISTAR TODOS
    public function findAll(): array
    {
        $sql = "SELECT * FROM usuarios_faker";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // BUSCAR POR ID
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios_faker WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // UPDATE
    public function update(Usuario $usuario): bool
    {
        $sql = "UPDATE usuarios_faker 
            SET nome = :nome, sobrenome = :sobrenome, email = :email, telefone = :telefone, endereco = :endereco, cidade = :cidade, cep = :cep, empresa = :empresa, cargo = :cargo, data_nascimento = :data_nascimento, numero_cartao = :numero_cartao, iban = :iban, uuid = :uuid
            WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':sobrenome' => $usuario->getSobrenome(),
            ':email' => $usuario->getEmail(),
            ':telefone' => $usuario->getTelefone(),
            ':endereco' => $usuario->getEndereco(),
            ':cidade' => $usuario->getCidade(),
            ':cep' => $usuario->getCep(),
            ':empresa' => $usuario->getEmpresa(),
            ':cargo' => $usuario->getCargo(),
            ':data_nascimento' => $usuario->getDataNascimento(),
            ':numero_cartao' => $usuario->getNumeroCartao(),
            ':iban' => $usuario->getIban(),
            ':uuid' => $usuario->getUuid(),
            ':id' => $usuario->getId()
        ]);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM usuarios_faker WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Inserir usuário fake com Faker
    public function insertFakeUsuario(): bool
    {
        $faker = Factory::create('pt_BR');

        $usuario = new Usuario();
        $usuario->setNome($faker->firstName);
        $usuario->setSobrenome($faker->lastName);
        $usuario->setEmail($faker->email);
        $usuario->setTelefone($faker->phoneNumber);
        $usuario->setEndereco($faker->address);
        $usuario->setCidade($faker->city);
        $usuario->setCep($faker->postcode);
        $usuario->setEmpresa($faker->company);
        $usuario->setCargo($faker->jobTitle);
        $usuario->setDataNascimento($faker->date('Y-m-d'));
        $usuario->setNumeroCartao($faker->creditCardNumber);
        $usuario->setIban($faker->iban('BR'));
        $usuario->setUuid($faker->uuid);

        return $this->insert($usuario);
    }

    // Inserir vários usuários fake
    public function insertManyFake(int $quantidade): void
    {
        for ($i = 0; $i < $quantidade; $i++) {
            $this->insertFakeUsuario();
        }
    }
}
