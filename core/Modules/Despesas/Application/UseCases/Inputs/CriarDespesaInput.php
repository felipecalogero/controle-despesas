<?php

namespace Core\Modules\Despesas\Application\UseCases\Inputs;

class CriarDespesaInput
{
    public function __construct(
        public string $descricao,
        public float $valor,
        public \DateTime $data,
    ) {}
}


