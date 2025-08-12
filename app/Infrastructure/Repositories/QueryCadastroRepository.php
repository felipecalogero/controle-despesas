<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Cadastro\Application\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioNaoEncontradoException;

class QueryCadastroRepository implements CadastroGateway
{
    public function salvar(UsuarioEntity $user): UsuarioEntity
    {
        $userModel = new User();
        $userModel->name = $user->name;
        $userModel->last_name = $user->lastName;
        $userModel->email = $user->email;
        $userModel->password = $user->password;
        $userModel->save();

        return new UsuarioEntity(
            $userModel->id,
            $userModel->name,
            $userModel->last_name,
            $userModel->email,
            $userModel->password
        );
    }

    public function excluir(int $id): bool
    {
        $user = User::query()->findOrFail($id);

        if (!$user) {
            throw new UsuarioNaoEncontradoException();
        }

        $user->delete();
        return true;
    }

    public function atualizar(UsuarioEntity $user): UsuarioEntity
    {
        // TODO: Implement atualizar() method.
    }

    public function buscarUsuario(string $email): ?UsuarioEntity
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return new UsuarioEntity(
            $user->id,
            $user->name,
            $user->last_name,
            $user->email,
            $user->password
        );
    }
}
