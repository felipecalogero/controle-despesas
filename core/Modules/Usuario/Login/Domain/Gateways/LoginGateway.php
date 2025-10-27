<?php

namespace Core\Modules\Usuario\Login\Domain\Gateways;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface LoginGateway
{
    public function buscarUsuario(string $email) : UsuarioEntity;
    public function atualizarSenha(int $userId, string $novaSenhaHash): bool;
}
