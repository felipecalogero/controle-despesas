<?php

namespace Core\Modules\Financeiro\Application\UseCases\Input;

class FinanceiroInput
{
    public function __construct(
        public readonly int $usuarioId,
        public readonly float $salario,
        public readonly int $limite
    ) {}
}
