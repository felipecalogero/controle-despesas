<?php

namespace Core\Modules\Despesas\Application\UseCases\Inputs;

use Carbon\Carbon;

class FiltrarDespesasInput
{
    public function __construct(
        public ?string $descricao,
        public ?int $mes,
        public ?string $dataInicial,
        public ?string $dataFinal
    ) {
    }
}
