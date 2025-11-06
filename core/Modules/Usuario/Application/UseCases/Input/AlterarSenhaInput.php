<?php

namespace Core\Modules\Usuario\Application\UseCases\Input;

class AlterarSenhaInput
{
    public function __construct(
        public readonly string $userMail,
        public readonly ?string $password,
        public readonly string $newPassword,
        public readonly string $confirmPassword
) {}
}
