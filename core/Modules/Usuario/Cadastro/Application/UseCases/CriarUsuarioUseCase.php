<?php

namespace Core\Modules\Usuario\Cadastro\Application\UseCases;

use Core\Modules\Usuario\Cadastro\Application\UseCases\Inputs\CriarUsuarioInput;
use Core\Modules\Usuario\Cadastro\Application\UseCases\Outputs\CriarUsuarioOutput;
use Core\Modules\Usuario\Cadastro\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;
use Core\Modules\Usuario\Login\Domain\Rules\UsuarioJaExisteRule;

class CriarUsuarioUseCase
{
    public function __construct(
        private UsuarioGateway $usuarioGateway,
        private UsuarioJaExisteRule $usuarioExiste
    ) {}

    public function execute(CriarUsuarioInput $input): CriarUsuarioOutput
    {
        $this->usuarioExiste->validar($input->email);

        $dataUser = [
            'name' => $input->name,
            'last_name' => $input->lastName,
            'email' => $input->email,
            'password' => $input->password
        ];

        $usuarioSalvo = $this->usuarioGateway->saveUser($dataUser);

        return new CriarUsuarioOutput(
            $usuarioSalvo->id,
            $usuarioSalvo->name,
            $usuarioSalvo->lastName,
            $usuarioSalvo->email,
            'Usuário cadastrado com sucesso!',
        );
    }
}
