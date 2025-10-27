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
        $dadosPerfil = [
            'usuarioId' => $input->usuarioId,
            'nome' => $input->nome,
            'sobrenome' => $input->sobrenome,
            'email' => $input->email,
            'telefone' => $input->telefone,
        ];

        $usuario = $this->usuarioGateway->buscarUsuarioId($input->usuarioId);
        $this->usuarioGateway->atualizarPerfil($dadosPerfil);

        return new UsuarioEntity(
            $usuario->id,
            $usuario->name,
            $usuario->lastName,
            $usuario->email,
            $usuario->password
        );
    }
}
