<?php

namespace Core\Modules\Despesas\Domain\Entities;

class DespesaEntity
{
    public ?int $id;
    public string $descricao;
    public float $valor;
    public \DateTime $data;
    public int $usuarioId;
    public ?\DateTime $createdAt = null;
    public ?\DateTime $updatedAt = null;

    /**
     * @param  ?int  $id
     * @param  string  $descricao
     * @param  float  $valor
     * @param  \DateTime  $data
     * @param  ?\DateTime  $createdAt
     * @param  ?\DateTime  $updatedAt
     */
    public function __construct
    (
        ?int $id,
        string $descricao,
        float $valor,
        \DateTime $data,
        int $usuarioId,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null,
    )
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->data = $data;
        $this->usuarioId = $usuarioId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    public function getData(): \DateTime
    {
        return $this->data;
    }

    public function setData(\DateTime $data): void
    {
        $this->data = $data;
    }

    public function getDataCadastro(): \DateTime
    {
        return $this->data;
    }

    public function setDataCadastro(\DateTime $dataDespesa): void
    {
        $this->data = $dataDespesa;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): void
    {
        $this->usuarioId = $usuarioId;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}

