<?php

namespace Core\Modules\Usuario\Login\Application\UseCases\Outputs;

class AutenticarUsuarioOutput
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $mensagem = ''
    ){}
}
