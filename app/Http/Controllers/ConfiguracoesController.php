<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterarSenhaRequest;
use App\Http\Requests\AtualizarPerfilRequest;
use App\Http\Requests\FinanceiroRequest;
use Core\Modules\Despesas\Application\UseCases\BuscarDespesasMesUseCase;
use Core\Modules\Financeiro\Application\UseCases\BuscarConfigFinanceiroUseCase;
use Core\Modules\Financeiro\Application\UseCases\Input\FinanceiroInput;
use Core\Modules\Financeiro\Application\UseCases\SalvarFinanceiroUseCase;
use Core\Modules\Usuario\Application\UseCases\AlterarSenhaUseCase;
use Core\Modules\Usuario\Application\UseCases\AtualizarPerfilUseCase;
use Core\Modules\Usuario\Application\UseCases\Input\AlterarSenhaInput;
use Core\Modules\Usuario\Application\UseCases\Input\AtualizarPerfilInput;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConfiguracoesController extends Controller
{
    public function __construct(
        private BuscarDespesasMesUseCase $buscarDespesasMensalUseCase,
        private SalvarFinanceiroUseCase $salvarFinanceiroUseCase,
        private BuscarConfigFinanceiroUseCase $buscarConfigFinanceiroUseCase,
        private AlterarSenhaUseCase $alterarSenhaUseCase,
        private AtualizarPerfilUseCase $atualizarPerfilUseCase,
    ) {
    }

    public function index()
    {
        $usuario = Auth::user();
        $despesasMes = $this->buscarDespesasMensalUseCase->execute();
        $configFinanceiro = $this->buscarConfigFinanceiroUseCase->execute();
        $totalMes = $despesasMes->total;
        $isOAuthUser = empty($usuario->password);

        return view('configuracoes', compact('usuario', 'configFinanceiro', 'totalMes', 'isOAuthUser'));
    }

    public function atualizarPerfil(AtualizarPerfilRequest $request)
    {
        $dados = $request->validated();

        $input = new AtualizarPerfilInput(
            $dados['nome'],
            $dados['sobrenome'],
            $dados['email'],
            $dados['telefone'],
        );

        $this->atualizarPerfilUseCase->execute($input);

        return back()->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    public function atualizarFinanceiro(FinanceiroRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $input = new FinanceiroInput(
            $userId,
            $data['salario_mensal'],
            $data['limite_alertas']
        );

        $this->salvarFinanceiroUseCase->execute($input);

        return back()->with('sucesso', 'Configurações financeiras atualizadas com sucesso!');
    }

    public function alterarSenha(AlterarSenhaRequest $request)
    {
        $input = new AlterarSenhaInput(
            auth()->user()->email,
            $request->senha_atual,
            $request->nova_senha,
            $request->nova_senha_confirmation
        );

        $output = $this->alterarSenhaUseCase->execute($input);

        if ($output->sucesso) {
            return redirect()->route('configuracoes.index')
                ->with('sucesso', $output->mensagem);
        }

        return back()->withErrors(['error' => $output->mensagem]);
    }
}
