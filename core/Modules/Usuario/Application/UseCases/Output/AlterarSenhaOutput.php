<?php

namespace Core\Modules\Usuario\Application\UseCases\Output;

class AlterarSenhaOutput
{
    public function __construct(
        public bool $sucesso,
        public string $mensagem
    ) {}
}
