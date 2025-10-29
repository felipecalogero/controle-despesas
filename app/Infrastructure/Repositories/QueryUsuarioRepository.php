<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;

class QueryUsuarioRepository implements UsuarioGateway
{
    public function buscarUsuarioId(int $usuarioId): ?UsuarioEntity
    {
        $usuario = User::query()->findOrFail($usuarioId);

        if (!$usuario) {
            return null;
        }

        return new UsuarioEntity(
            $usuario->id,
            $usuario->nome,
            $usuario->last_name,
            $usuario->email,
            $usuario->password,
        );
    }

    public function findOrCreateFromSocial(string $provider, object $socialUser): UsuarioEntity
    {
        $nameParts = explode(' ', $socialUser->name);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        // Busca usuário existente pelo e-mail
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
                $user->avatar,
                $user->provider_name,
                $user->provider_id
            );
        }

        // Cria novo usuário
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
            $newUser->avatar,
            $newUser->provider_name,
            $newUser->provider_id
        );
    }

    public function atualizarSenha(int $usuarioId, string $novaSenhaHash): bool
    {
        return User::where('id', $usuarioId)
                ->update(['password' => $novaSenhaHash]) > 0;
    }

    public function atualizarPerfil(array $dadosPerfil): bool
    {
        return User::where('id', $dadosPerfil['usuarioId'])
                ->update([
                    'name' => $dadosPerfil['nome'],
                    'last_name' => $dadosPerfil['sobrenome'],
                    'email' => $dadosPerfil['email'],
                ]);
    }
}
