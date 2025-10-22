<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Social\Domain\Gateways\SocialGateway;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class QuerySocialRepository implements SocialGateway
{
    public function getGoogleUser(): ?UsuarioEntity
    {
        // TODO: Implement google() method.
    }

    public function getFacebookUser(): ?UsuarioEntity
    {
        $facebookUser = Socialite::driver('facebook')->user();

        if(!$facebookUser) {
            return null;
        }

        return new UsuarioEntity(
            $facebookUser->id,
            $facebookUser->name,
            $facebookUser->lastName,
            $facebookUser->email,
            Hash::make(Str::random(32))
        );
    }

    public function getGithubUser(): ?UsuarioEntity
    {
        // TODO: Implement github() method.
    }
}
