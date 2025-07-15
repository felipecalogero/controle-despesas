<?php

namespace Core\Modules\Despesas\Application\UseCases\Outputs;

class CriarDespesaOutput
{
    public function __construct(
        public ?int $id,
        public array $dados,
        public string $mensagem
    ) {}
}
