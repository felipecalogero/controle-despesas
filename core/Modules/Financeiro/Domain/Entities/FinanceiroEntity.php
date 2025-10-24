<?php

namespace Core\Modules\Financeiro\Domain\Entities;

class FinanceiroEntity
{
    public function __construct(
        public int $usuarioId,
        public float $salario,
        public int $limite
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): void
    {
        $this->usuarioId = $usuarioId;
    }

    public function getSalario(): float
    {
        return $this->salario;
    }

    public function setSalario(float $salario): void
    {
        $this->salario = $salario;
    }

    public function getLimite(): int
    {
        return $this->limite;
    }

    public function setLimite(int $limite): void
    {
        $this->limite = $limite;
    }
}
