<?php

namespace Core\Modules\Usuario\Cadastro\Application\UseCases;

use Core\Modules\Usuario\Cadastro\Application\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Cadastro\Application\UseCases\Inputs\CriarUsuarioInput;
use Core\Modules\Usuario\Cadastro\Application\UseCases\Outputs\CriarUsuarioOutput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Login\Domain\Rules\UsuarioJaExisteRule;

class CriarUsuarioUseCase
{
    public function __construct(
        private CadastroGateway $cadastroInterface,
        private UsuarioJaExisteRule $usuarioExiste
    ) {}

    public function execute(CriarUsuarioInput $input): CriarUsuarioOutput
    {
        $this->usuarioExiste->validar($input->email);
        $usuario = new UsuarioEntity(
            null,
            $input->name,
            $input->lastName,
            $input->email,
            $input->password
        );

        $usuarioSalvo = $this->cadastroInterface->saveUser($usuario);

        return new CriarUsuarioOutput(
            $usuarioSalvo->id,
            $usuarioSalvo->name,
            $usuarioSalvo->lastName,
            $usuarioSalvo->email,
            'Usuário cadastrado com sucesso!',
        );
    }
}
