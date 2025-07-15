<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class ListarDespesasOutput
{
    public function __construct(
        public array $despesas,
        public int $total
    ) {}
}
