<?php

namespace Core\Modules\Despesas\Application\UseCases\Inputs;

class DeletarDespesaInput
{
    public function __construct(
        public int $id
    ) {}
}


