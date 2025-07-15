<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

Class AtualizarDespesaOutput
{
    public function __construct(
        public int $id,
        public array $dados,
        public string $mensagem = ''
    ){}
}
