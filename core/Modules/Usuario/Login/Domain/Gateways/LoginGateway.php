<?php

namespace Core\Modules\Usuario\Login\Domain\Gateways;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface LoginGateway
{
    public function buscarUsuario(string $email);
    public function verificarSenha(UsuarioEntity $user, string $password);
}
