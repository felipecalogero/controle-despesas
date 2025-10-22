<?php

namespace Core\Modules\Usuario\Social\Domain\Gateways;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface SocialGateway
{
    public function getGoogleUser(): ?UsuarioEntity;
    public function getFacebookUser(): ?UsuarioEntity;
    public function getGithubUser(): ?UsuarioEntity;
}
