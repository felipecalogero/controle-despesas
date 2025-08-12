<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

Class AtualizarDespesaOutput
{
    public function __construct(
        public readonly int $id,
        public readonly array $dados,
        public readonly string $mensagem = ''
    ){}
}
