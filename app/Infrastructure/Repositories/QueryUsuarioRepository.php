<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Application\UseCases\Input\AlterarSenhaInput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;

class QueryUsuarioRepository implements UsuarioGateway
{

    public function atualizarSenha(int $usuarioId, string $novaSenhaHash): bool
    {
        return User::where('id', $usuarioId)
                ->update(['password' => $novaSenhaHash]) > 0;
    }

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
}
