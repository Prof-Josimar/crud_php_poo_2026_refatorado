<?php

namespace App\DAO;

use App\Config\Database;
use App\Models\Pessoa;
use PDO;
use Throwable;

class PessoaDAO
{
    private PDO $conn;

    // Injeção de dependência: em teste dá para passar outro PDO.
    public function __construct(?PDO $conn = null)
    {
        $this->conn = $conn ?? Database::connection();
    }

    public function insert(Pessoa $pessoa): bool
    {
        $sql = "INSERT INTO pessoas (nome, telefone, cpf, endereco)
                VALUES (:nome, :telefone, :cpf, :endereco)";

        return $this->conn->prepare($sql)->execute([
            ':nome'     => $pessoa->getNome(),
            ':telefone' => $pessoa->getTelefone(),
            ':cpf'      => $pessoa->getCpf(),
            ':endereco' => $pessoa->getEndereco(),
        ]);
    }

    public function findAllPaginado(int $limite, int $offset): array
    {
        $stmt = $this->conn->prepare(
            "SELECT id, nome, telefone, cpf, endereco FROM pessoas ORDER BY nome LIMIT :limite OFFSET :offset"
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->conn->query("SELECT COUNT(*) FROM pessoas")->fetchColumn();
    }

    public function findByNome(string $nome): array
    {
        $stmt = $this->conn->prepare(
            "SELECT id, nome, telefone, cpf, endereco FROM pessoas WHERE nome LIKE :nome ORDER BY nome"
        );
        $stmt->execute([':nome' => "%$nome%"]);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM pessoas WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function update(Pessoa $pessoa): bool
    {
        $sql = "UPDATE pessoas
                SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco,
                    updatedAt = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nome'     => $pessoa->getNome(),
            ':telefone' => $pessoa->getTelefone(),
            ':cpf'      => $pessoa->getCpf(),
            ':endereco' => $pessoa->getEndereco(),
            ':id'       => $pessoa->getId(),
        ]);

        // Como updatedAt sempre muda, rowCount() = 0 significa "id não existe".
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        return $this->conn->prepare("DELETE FROM pessoas WHERE id = :id")
                          ->execute([':id' => $id]);
    }

    /** Apaga movimentações e pessoas na mesma transação; depois zera os AUTO_INCREMENT. */
    public function deleteAll(): void
    {
        try {
            $this->conn->beginTransaction();
            $this->conn->exec("DELETE FROM movimentacao");
            $this->conn->exec("DELETE FROM pessoas");
            $this->conn->commit();
        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }

        // ALTER TABLE faz commit implícito no MySQL/MariaDB, por isso fica FORA da transação
        // (dentro dela, o commit() do PHP 8 lançava "There is no active transaction").
        $this->conn->exec("ALTER TABLE movimentacao AUTO_INCREMENT = 1");
        $this->conn->exec("ALTER TABLE pessoas AUTO_INCREMENT = 1");
    }
}
