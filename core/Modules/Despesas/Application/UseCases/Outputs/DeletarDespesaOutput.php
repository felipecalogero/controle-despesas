<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class DeletarDespesaOutput
{
    public function __construct(
        public bool $sucesso,
        public string $mensagem = ''
    ) {}
}
