<?php

namespace App\Http\Controllers;

use Core\Modules\Despesas\Application\UseCases\BuscarDespesasMesUseCase;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConfiguracoesController extends Controller
{
    public function __construct(
        private BuscarDespesasMesUseCase $buscarDespesasMensalUseCase,
    ) {}
    public function index()
    {
        $usuario = Auth::user();
        $despesasMes = $this->buscarDespesasMensalUseCase->execute();
        $totalMes = $despesasMes->total;

        return view('configuracoes', compact('usuario', 'totalMes'));
    }

    public function atualizarPerfil(Request $request)
    {
        // Lógica para atualizar perfil
        return back()->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    public function atualizarFinanceiro(Request $request)
    {
        // Lógica para atualizar configurações financeiras
        return back()->with('sucesso', 'Configurações financeiras atualizadas!');
    }

    public function alterarSenha(Request $request)
    {
        // Lógica para alterar senha
        return back()->with('sucesso', 'Senha alterada com sucesso!');
    }
}
