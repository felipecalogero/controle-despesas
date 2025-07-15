<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

Class EditarDespesaOutput{
    public function __construct(
        public int $id,
        public string $descricao,
        public float $valor,
        public \DateTime $data,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
    ) {}
}
