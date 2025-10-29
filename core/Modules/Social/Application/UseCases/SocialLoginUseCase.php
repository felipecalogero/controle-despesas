<?php

namespace Core\Modules\Social\Application\UseCases;

use Core\Modules\Social\Domain\Gateway\SocialGateway;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;

class SocialLoginUseCase
{
    public function __construct(
        private SocialGateway $socialGateway,
        private UsuarioGateway $usuarioGateway,
    ) {}

    public function execute(string $provider) {
        $socialUser = $this->socialGateway->getUser('facebook');
        $user = $this->usuarioGateway->findOrCreateFromSocial($provider, $socialUser);
        $accessToken = $this->socialGateway->createTokenForUser($user);

        return (object) [
            'userId' => $user->id,
            'accessToken' => $accessToken,
        ];
    }
}
