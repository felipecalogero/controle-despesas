<?php

namespace Core\Modules\Usuario\Domain\Gateway;

use Core\Modules\Usuario\Application\UseCases\Input\AlterarSenhaInput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface UsuarioGateway
{
    public function saveUser(array $dataUser): UsuarioEntity;
    public function getUser(string $email): ?UsuarioEntity;
    public function updatePassword(int $usuarioId, string $novaSenhaHash): bool;
    public function updatePerfil(array $dadosPerfil): bool;
    public function findOrCreateFromSocial(string $provider, object $socialUser): UsuarioEntity;
}
