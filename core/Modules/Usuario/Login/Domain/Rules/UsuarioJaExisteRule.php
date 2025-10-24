<?php

namespace Core\Modules\Usuario\Login\Domain\Rules;


use Core\Modules\Usuario\Cadastro\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioJaExisteException;

class UsuarioJaExisteRule
{
    public function __construct(
        private CadastroGateway $cadastroGateway
    ) {}

    public function validar(string $email): void
    {
        $usuario = $this->cadastroGateway->getUser($email);

        if ($usuario) {
            throw new UsuarioJaExisteException();
        }
    }
}
