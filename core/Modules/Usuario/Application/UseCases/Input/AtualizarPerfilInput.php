<?php

namespace Core\Modules\Usuario\Application\UseCases\Input;

class AtualizarPerfilInput
{
    public function __construct(
        public readonly int $usuarioId,
        public readonly string $nome,
        public readonly string $sobrenome,
        public readonly string $email,
        public readonly ?string $telefone,
    ) {}
}
