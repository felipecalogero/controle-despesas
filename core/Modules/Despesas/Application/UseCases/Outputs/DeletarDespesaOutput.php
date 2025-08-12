<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class DeletarDespesaOutput
{
    public function __construct(
        public readonly bool $sucesso,
        public readonly string $mensagem = ''
    ) {}
}
