<?php

namespace Core\Modules\Despesas\Application\UseCases\Inputs;

class ListarDespesasInput
{
    public function __construct(
        public ?int $id = null,
        public ?string $descricao = null,
        public ?float $valor = null,
        public ?\DateTime $data = null
    ) {}
}


