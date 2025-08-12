<?php

namespace Core\Modules\Usuario\Cadastro\Application\UseCases\Outputs;

class CriarUsuarioOutput
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $message,
    ){}
}
