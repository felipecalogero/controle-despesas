<?php

namespace Core\Modules\Usuario\Login\Application\UseCases;

use Core\Modules\Usuario\Login\Application\UseCases\Inputs\AutenticarUsuarioInput;
use Core\Modules\Usuario\Login\Application\UseCases\Outputs\AutenticarUsuarioOutput;
use Core\Modules\Usuario\Login\Domain\Gateways\LoginGateway;

class AutenticarUsuarioUseCase
{
    private LoginGateway $loginGateway;

    public function __construct(LoginGateway $loginGateway){
        $this->loginGateway = $loginGateway;
    }

    public function execute(AutenticarUsuarioInput $input)
    {
        $user = $this->loginGateway->buscarUsuario($input->email);
        $this->loginGateway->verificarSenha($user, $input->password);

        return new AutenticarUsuarioOutput(
            $user->id,
            $user->email,
            'Login realizado com sucesso!'
        );
    }
}
