<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterarSenhaRequest;
use App\Http\Requests\FinanceiroRequest;
use Core\Modules\Despesas\Application\UseCases\BuscarDespesasMesUseCase;
use Core\Modules\Financeiro\Application\UseCases\BuscarConfigFinanceiroUseCase;
use Core\Modules\Financeiro\Application\UseCases\Input\FinanceiroInput;
use Core\Modules\Financeiro\Application\UseCases\SalvarFinanceiroUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfiguracoesController extends Controller
{
    public function __construct(
        private BuscarDespesasMesUseCase $buscarDespesasMensalUseCase,
        private SalvarFinanceiroUseCase $salvarFinanceiroUseCase,
        private BuscarConfigFinanceiroUseCase $buscarConfigFinanceiroUseCase,
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

    public function atualizarPerfil(Request $request)
    {
        // Lógica para atualizar perfil
        return back()->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    public function atualizarFinanceiro(FinanceiroRequest $request)
    {
        $usuarioId = auth()->user()->id;
        $dados = $request->validated();

        $input = new FinanceiroInput(
            $usuarioId,
            $dados['salario_mensal'],
            $dados['limite_alertas']
        );

        $this->salvarFinanceiroUseCase->execute($input);

        return redirect()->route('configuracoes.index')
            ->with('sucesso', 'Configurações financeiras atualizadas com sucesso!');
    }

    public function alterarSenha(Request $request)
    {
        // Lógica para alterar senha
        return back()->with('sucesso', 'Senha alterada com sucesso!');
    }
}
