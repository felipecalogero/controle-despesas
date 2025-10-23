<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Calcule o total do mês atual para o resumo
        $totalMes = 0; // Sua lógica para calcular gastos do mês

        return view('configuracoes', compact('user', 'totalMes'));
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
