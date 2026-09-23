<?php

namespace App\Models;

class Movimentacao
{
    private ?int $id = null;

    public function __construct(
        private int $idPessoa,
        private float $credito = 0.00,
        private float $debito = 0.00,
        private ?string $observacao = null
    ) {
    }

    public function getId(): ?int            { return $this->id; }
    public function getIdPessoa(): int       { return $this->idPessoa; }
    public function getCredito(): float      { return $this->credito; }
    public function getDebito(): float       { return $this->debito; }
    public function getObservacao(): ?string { return $this->observacao; }

    public function setId(int $id): void { $this->id = $id; }
}
