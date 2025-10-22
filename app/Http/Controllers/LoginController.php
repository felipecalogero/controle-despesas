<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Core\Modules\Despesas\Application\UseCases\CriarDespesaUseCase;
use Core\Modules\Usuario\Cadastro\Application\UseCases\CriarUsuarioUseCase;
use Core\Modules\Usuario\Cadastro\Application\UseCases\Inputs\CriarUsuarioInput;
use Core\Modules\Usuario\Login\Application\UseCases\AutenticarUsuarioUseCase;
use Core\Modules\Usuario\Login\Application\UseCases\Inputs\AutenticarUsuarioInput;
use Core\Modules\Usuario\Social\Application\UseCases\FacebookUseCase;
use Core\Modules\Usuario\Social\Domain\Gateways\SocialGateway;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 *
 */
class LoginController
{
    public function __construct(
        private AutenticarUsuarioUseCase $autenticarUsuarioUseCase,
        private FacebookUseCase $facebookUseCase,
        private CriarUsuarioUseCase $criarUsuarioUseCase,
    ){}

    /**
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $tipo = $request->input('tipo');
        if ($tipo === 'login') {
            $validator = Validator::make($request->all(), (new LoginRequest())->rules());

            if ($validator->fails()) {
                dd($validator->errors());
            }

            $dados = $validator->validate();
            return $this->handleLogin($dados);
        }

        if ($tipo === 'cadastro') {
            $validator = Validator::make($request->all(), (new CadastroRequest())->rules());

            if ($validator->fails()) {
                dd($validator->errors());
            }

            $dados = $validator->validate();

            return $this->handleCadastro($dados);
        }
    }

    private function handleLogin($dados){
        try{
            $input = new AutenticarUsuarioInput(
                $dados['email'],
                $dados['password']
            );

            $output = $this->autenticarUsuarioUseCase->execute($input);

            $user = User::find($output->id);
            Auth::login($user);

            return redirect()
                ->route('despesas.index')
                ->with('success', $output->mensagem);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['login' => $e->getMessage()]);
        }
    }

    private function handleCadastro($dados)
    {
        try{
            $input = new CriarUsuarioInput(
                $dados['name'],
                $dados['last_name'],
                $dados['email'],
                $dados['password']
            );
            $output = $this->criarUsuarioUseCase->execute($input);

            $user = User::find($output->id);
            Auth::login($user);

            return redirect()
                ->route('despesas.index')
                ->with('success', $output->message);
        } catch(Exception $e){
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['login' => $e->getMessage()]);
        }
    }

    public function loginWithFacebook() {
        $facebookUser = $this->facebookUseCase->socialGateway->getFacebookUser();
        $output = $this->facebookUseCase->execute($facebookUser);

        Auth::loginUsingId($output->id);

        return redirect()
            ->route('despesas.index')
            ->with('success', $output->message);
    }
}
