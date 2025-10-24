<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class ListarDespesasOutput
{
    public function __construct(
        public readonly array $despesas,
        public readonly float $total
    ) {}
}
