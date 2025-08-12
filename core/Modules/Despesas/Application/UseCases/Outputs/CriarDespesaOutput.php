<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class CriarDespesaOutput
{
    public function __construct(
        public readonly ?int $id,
        public readonly array $dados,
        public readonly string $mensagem
    ) {}
}
