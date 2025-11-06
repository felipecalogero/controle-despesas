<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;
use Core\Modules\Usuario\Login\Domain\Exceptions\UsuarioNaoEncontradoException;

class QueryUsuarioRepository implements UsuarioGateway
{
    public function saveUser(array $dataUser): UsuarioEntity
    {
        $userModel = new User();
        $userModel->name = $dataUser['name'];
        $userModel->last_name = $dataUser['last_name'];
        $userModel->email = $dataUser['email'];
        $userModel->password = $dataUser['password'];
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

    public function getUser(string $email): ?UsuarioEntity
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
            $user->password,
            $user->avatar,
            $user->provider_name,
            $user->provider_id,
        );
    }

    public function findOrCreateFromSocial(string $provider, object $socialUser): UsuarioEntity
    {
        $nameParts = explode(' ', $socialUser->name);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        $user = User::where('email', $socialUser->email)->first();

        if ($user) {
            if (!$user->provider_id) {
                $user->update([
                    'provider_id' => $socialUser->id,
                    'provider_name' => $provider,
                ]);
            }

            return new UsuarioEntity(
                $user->id,
                $user->name,
                $user->last_name,
                $user->email,
                null,
                $user->avatar,
                $user->provider_name,
                $user->provider_id
            );
        }

        $newUser = User::create([
            'name' => $firstName,
            'last_name' => $lastName,
            'email' => $socialUser->email,
            'avatar' => $socialUser->avatar,
            'provider_id' => $socialUser->id,
            'provider_name' => $provider,
        ]);

        return new UsuarioEntity(
            $newUser->id,
            $newUser->name,
            $newUser->last_name,
            $newUser->email,
            $user?->password,
            $newUser->avatar,
            $newUser->provider_name,
            $newUser->provider_id
        );
    }

    public function updatePassword(int $usuarioId, string $novaSenhaHash): bool
    {
        return User::where('id', $usuarioId)
                ->update(['password' => $novaSenhaHash]) > 0;
    }

    public function updatePerfil(array $dadosPerfil): bool
    {
        return User::where('id', $dadosPerfil['usuarioId'])
                ->update([
                    'name' => $dadosPerfil['nome'],
                    'last_name' => $dadosPerfil['sobrenome'],
                    'email' => $dadosPerfil['email'],
                ]);
    }
}
