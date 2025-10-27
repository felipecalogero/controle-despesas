<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Login\Domain\Exceptions\SenhaIncorretaException;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioNaoEncontradoException;
use Core\Modules\Usuario\Login\Domain\Gateways\LoginGateway;
use Illuminate\Support\Facades\Hash;

class QueryLoginRepository implements LoginGateway
{
    public function buscarUsuario(string $email) : UsuarioEntity
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new UsuarioNaoEncontradoException();
        }

        return new UsuarioEntity(
            $user->id,
            $user->nome,
            $user->lastName,
            $user->email,
            $user->password
        );
    }

    public function atualizarSenha(int $usuarioId, string $password): bool
    {
        if (!Hash::check($password, $usuarioId->password)) {
            throw new SenhaIncorretaException();
        }
    }
}
