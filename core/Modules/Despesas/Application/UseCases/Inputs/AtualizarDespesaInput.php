<?php

namespace Core\Modules\Despesas\Application\UseCases\Inputs;

class AtualizarDespesaInput
{
    public function __construct(
        public int $id,
        public string $descricao,
        public float $valor,
        public \DateTIme $data,
    ) {}
}


