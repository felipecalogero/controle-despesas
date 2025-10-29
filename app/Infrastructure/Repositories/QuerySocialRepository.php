<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Social\Domain\Gateway\SocialGateway;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Laravel\Socialite\Facades\Socialite;

class QuerySocialRepository implements SocialGateway
{
    public function getUser(string $provider): object
    {
        $socialUser = Socialite::driver($provider)->user();

        return (object) [
            'id' => $socialUser->getId(),
            'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'avatar' => $socialUser->getAvatar(),
            'provider' => $provider,
        ];
    }

    public function createTokenForUser(UsuarioEntity $usuario): string
    {
        $userModel = User::findOrFail($usuario->id);
        return $userModel->createToken('Social Login')->accessToken;
    }
}
