<?php

namespace Core\Modules\Usuario\Social\Application\UseCases;


use App\Infrastructure\Repositories\QueryCadastroRepository;
use App\Models\User;
use Core\Modules\Usuario\Cadastro\Application\UseCases\Outputs\CriarUsuarioOutput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;
use Core\Modules\Usuario\Social\Domain\Gateways\SocialGateway;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FacebookUseCase
{
    public function __construct(
        private QueryCadastroRepository $queryCadastroRepository,
        public SocialGateway $socialGateway
    ) {}

    public function execute($facebookUser){
        $user = $this->queryCadastroRepository->getUser($facebookUser->email);

        if(!$user){
            [$firstName, $lastName] = $this->splitName($facebookUser->name);
            $user = $this->queryCadastroRepository->saveUser(
                $firstName,
                $lastName,
                $facebookUser->email,
                Hash::make(Str::random(32))
            );
        }

        return new CriarUsuarioOutput(
            $user->id,
            $user->name,
            $user->lastName,
            $user->email,
            'Usuário cadastrado com sucesso!',
        );
    }

    private function splitName(string $fullName): array
    {
        $parts = explode(' ', trim($fullName));
        $firstName = $parts[0];
        $lastName = $parts[count($parts) - 1];

        return [$firstName, $lastName];
    }
}
