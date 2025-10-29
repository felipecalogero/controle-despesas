<?php

namespace App\Http\Controllers;

use Core\Modules\Social\Application\UseCases\SocialLoginUseCase;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;
use Illuminate\Support\Facades\Auth;

class SocialController
{
    public function __construct(
        private SocialLoginUseCase $socialLoginUseCase,
    ) {}

    public function handleFacebook() {
        $output = $this->socialLoginUseCase->execute('facebook');

        Auth::loginUsingId($output->userId, true);

        session(['passport_token' => $output->accessToken]);

        return redirect()
            ->route('despesas.index')
            ->with('success', 'Login via Facebook realizado com sucesso!');
    }

}
