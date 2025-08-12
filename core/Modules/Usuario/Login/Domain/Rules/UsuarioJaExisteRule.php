<?php

namespace Core\Modules\Usuario\Login\Domain\Rules;


use Core\Modules\Usuario\Cadastro\Application\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioJaExisteException;

class UsuarioJaExisteRule
{
    public function __construct(
        private CadastroGateway $cadastroGateway
    ) {}

    public function validar(string $email): void
    {
        $usuario = $this->cadastroGateway->buscarUsuario($email);

        if ($usuario) {
            throw new UsuarioJaExisteException();
        }
    }
}
