<?php

namespace Core\Modules\Usuario\Cadastro\Application\UseCases\Inputs;

/**
 *
 */
class CriarUsuarioInput
{
    public function __construct(
        public string $name,
        public string $lastName,
        public string $email,
        public string $password,
    ){}
}
