<?php

namespace App\DAO;

use App\Config\Database;
use App\Models\Movimentacao;
use PDO;
use Throwable;

class MovimentacaoDAO
{
    private PDO $conn;

    public function __construct(?PDO $conn = null)
    {
        $this->conn = $conn ?? Database::connection();
    }

    public function insert(Movimentacao $mov): bool
    {
        // DataOperacao e CreatedAt já têm DEFAULT current_timestamp() no banco.
        $sql = "INSERT INTO movimentacao (idPessoa, Credito, Debito, Observacao)
                VALUES (:idPessoa, :credito, :debito, :observacao)";

        return $this->conn->prepare($sql)->execute([
            ':idPessoa'   => $mov->getIdPessoa(),
            ':credito'    => $mov->getCredito(),
            ':debito'     => $mov->getDebito(),
            ':observacao' => $mov->getObservacao(),
        ]);
    }

    /** Débito na origem + crédito no destino: os dois gravam ou nenhum grava. */
    public function transferir(int $origem, string $nomeOrigem, int $destino, string $nomeDestino, float $valor): void
    {
        try {
            $this->conn->beginTransaction();

            $this->insert(new Movimentacao($origem, 0.00, $valor, "Transferência para {$nomeDestino} via sistema"));
            $this->insert(new Movimentacao($destino, $valor, 0.00, "Recebimento de transferência de {$nomeOrigem} via sistema"));

            $this->conn->commit();
        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function findAll(): array
    {
        $sql = "SELECT m.id, m.idPessoa, p.nome, m.Credito, m.Debito, m.DataOperacao, m.Observacao
                FROM movimentacao m
                INNER JOIN pessoas p ON p.id = m.idPessoa
                ORDER BY m.DataOperacao DESC, m.id DESC";

        return $this->conn->query($sql)->fetchAll();
    }

    public function findByPessoa(int $idPessoa): array
    {
        $sql = "SELECT id, Credito, Debito, DataOperacao, Observacao
                FROM movimentacao
                WHERE idPessoa = :idPessoa
                ORDER BY DataOperacao DESC, id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idPessoa' => $idPessoa]);

        return $stmt->fetchAll();
    }

    public function getSaldo(int $idPessoa): float
    {
        $sql = "SELECT COALESCE(SUM(Credito), 0) - COALESCE(SUM(Debito), 0)
                FROM movimentacao
                WHERE idPessoa = :idPessoa";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idPessoa' => $idPessoa]);

        return (float) $stmt->fetchColumn();
    }

    /** Saldo de todas as pessoas (antes eram dois métodos quase idênticos). */
    public function getSaldos(bool $somentePositivos = false): array
    {
        $sql = "SELECT p.id AS idPessoa, p.nome,
                       COALESCE(SUM(m.Credito), 0) - COALESCE(SUM(m.Debito), 0) AS saldo
                FROM pessoas p
                LEFT JOIN movimentacao m ON m.idPessoa = p.id
                GROUP BY p.id, p.nome"
             . ($somentePositivos ? " HAVING saldo > 0 ORDER BY p.nome" : " ORDER BY saldo DESC, p.nome");

        return $this->conn->query($sql)->fetchAll();
    }
}
