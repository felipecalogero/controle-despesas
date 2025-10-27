<?php

namespace Core\Modules\Usuario\Application\UseCases;

use Core\Modules\Usuario\Application\UseCases\Input\AlterarSenhaInput;
use Core\Modules\Usuario\Application\UseCases\Output\AlterarSenhaOutput;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Bridge\UserRepository;

class AlterarSenhaUseCase
{
    public function __construct(
        private UsuarioGateway $usuarioGateway
    ) {}

    public function execute(AlterarSenhaInput $input): AlterarSenhaOutput
    {
        $usuario = $this->usuarioGateway->buscarUsuarioId($input->usuarioId);

        if (!$usuario) {
            return new AlterarSenhaOutput(false, 'Usuário não encontrado');
        }

        // Se usuário tem senha, verificar senha atual
        if (!empty($usuario->password) && !Hash::check($input->senha, $usuario->password)) {
            return new AlterarSenhaOutput(false, 'Senha atual incorreta');
        }

        // Atualizar senha
        $senhaAlterada = $this->usuarioGateway->atualizarSenha(
            $input->usuarioId,
            Hash::make($input->novaSenha)
        );

        if (!$senhaAlterada) {
            return new AlterarSenhaOutput(false, 'Erro ao alterar senha');
        }

        return new AlterarSenhaOutput(true, 'Senha alterada com sucesso');
    }
}
