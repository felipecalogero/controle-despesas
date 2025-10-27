<?php

namespace Core\Modules\Usuario\Application\UseCases\Input;

class AlterarSenhaInput
{
    public function __construct(
        public readonly int $usuarioId,
        public readonly ?string $senha,
        public readonly string $novaSenha,
        public readonly string $novaSenhaConfirmada
) {}
}
