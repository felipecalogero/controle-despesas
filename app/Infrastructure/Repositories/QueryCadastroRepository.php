<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Cadastro\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioNaoEncontradoException;

class QueryCadastroRepository implements CadastroGateway
{
    public function saveUser(string $name, string $lastName, string $email, string $password): UsuarioEntity
    {
        $userModel = new User();
        $userModel->name = $name;
        $userModel->last_name = $lastName;
        $userModel->email = $email;
        $userModel->password = $password;
        $userModel->save();

        return new UsuarioEntity(
            $userModel->id,
            $userModel->name,
            $userModel->last_name,
            $userModel->email,
            $userModel->password,
            $userModel->avatar,
            $userModel->provider_name,
            $userModel->provider_id,
        );
    }

    public function deleteUser(int $id): bool
    {
        $user = User::query()->findOrFail($id);

        if (!$user) {
            throw new UsuarioNaoEncontradoException();
        }

        $user->delete();
        return true;
    }

    public function getUser(string $mail): ?UsuarioEntity
    {
        $user = User::where('email', $mail)->first();

        if (!$user) {
            return null;
        }

        return new UsuarioEntity(
            $user->id,
            $user->name,
            $user->last_name,
            $user->email,
            $user->password,
            $user->avatar,
            $user->provider_name,
            $user->provider_id,
        );
    }
}
