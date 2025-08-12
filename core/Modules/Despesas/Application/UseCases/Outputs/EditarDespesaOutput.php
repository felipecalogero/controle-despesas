<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

Class EditarDespesaOutput{
    public function __construct(
        public readonly int $id,
        public readonly string $descricao,
        public readonly float $valor,
        public readonly \DateTime $data,
        public readonly \DateTime $createdAt,
        public readonly \DateTime $updatedAt,
    ) {}
}
