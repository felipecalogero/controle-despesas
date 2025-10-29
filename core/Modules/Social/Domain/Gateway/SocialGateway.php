<?php

namespace Core\Modules\Social\Domain\Gateway;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface SocialGateway
{
    public function createTokenForUser(UsuarioEntity $usuario): string;
    public function getUser(string $provider): object;
}
