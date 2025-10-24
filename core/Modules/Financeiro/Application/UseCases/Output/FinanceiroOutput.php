<?php

namespace Core\Modules\Financeiro\Application\UseCases\Output;

class FinanceiroOutput
{
    public function __construct(
        public float $salario,
        public int $limite
    ) {}
}
