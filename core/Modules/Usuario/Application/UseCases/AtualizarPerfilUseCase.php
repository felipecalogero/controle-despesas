<?php

namespace Core\Modules\Usuario\Application\UseCases;

use Core\Modules\Usuario\Application\UseCases\Input\AtualizarPerfilInput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;

class AtualizarPerfilUseCase
{
    public function __construct(
        private UsuarioGateway $usuarioGateway
    ) {}

    public function execute(AtualizarPerfilInput $input) {
        $usuario = $this->usuarioGateway->getUser($input->email);

        $dadosPerfil = [
            'usuarioId' => $usuario->id,
            'nome' => $input->nome,
            'sobrenome' => $input->sobrenome,
            'email' => $input->email,
            'telefone' => $input->telefone,
        ];

        $this->usuarioGateway->updatePerfil($dadosPerfil);

        return new UsuarioEntity(
            $usuario->id,
            $usuario->name,
            $usuario->lastName,
            $usuario->email,
            $usuario->password,
            $usuario->avatar,
            $usuario->providerName,
            $usuario->providerId
        );
    }
}
