<?php

namespace App\Http\Controllers;

use App\Http\Requests\DespesaRequest;
use App\Http\Requests\FiltrarDespesasRequest;
use Core\Modules\Despesas\Application\UseCases\AtualizarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\CriarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\DeletarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\EditarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\FiltrarDespesasUseCase;
use Core\Modules\Despesas\Application\UseCases\Inputs\AtualizarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\Inputs\CriarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\Inputs\FiltrarDespesasInput;
use Core\Modules\Despesas\Application\UseCases\ListarDespesasUseCase;
use Illuminate\Routing\Controller;

class DespesaController extends Controller
{
    public function __construct(
        private ListarDespesasUseCase $listarDespesas,
        private FiltrarDespesasUseCase $filtrarDespesas
    ) {}

    public function index()
    {
        $output = $this->listarDespesas->execute();

        return view('index', [
            'despesas' => $output->despesas,
            'total' => $output->total,
        ]);
    }

    public function create()
    {
        return view('cadastro');
    }

    public function store(DespesaRequest $request, CriarDespesaUseCase $criar)
    {
        $dados = $request->validated();
        $data = \DateTime::createFromFormat('Y-m-d', $dados['data']);

        $input = new CriarDespesaInput(
            $dados['descricao'],
            $dados['valor'],
            $data,
        );

        $output = $criar->execute($input);

        return redirect()
            ->route('despesas.index')
            ->with('sucesso', $output->mensagem);
    }

    public function edit(int $id, EditarDespesaUseCase $buscar)
    {
        $output = $buscar->execute($id);
        return view('index', compact('output'));
    }

    public function update(int $id, AtualizarDespesaUseCase $atualizar, DespesaRequest $request)
    {
        $dados = $request->validated();
        $data = \DateTime::createFromFormat('Y-m-d', $dados['data']);

        $input = new AtualizarDespesaInput(
            $id,
            $dados['descricao'],
            $dados['valor'],
            $data
        );

        $output = $atualizar->execute($input);

        return redirect()
            ->route('despesas.index')
            ->with('sucesso', $output->mensagem);
    }

    public function destroy(int $id, DeletarDespesaUseCase $deletar)
    {
        $output = $deletar->execute($id);
        return redirect()
            ->route('despesas.index')
            ->with('sucesso', $output->mensagem);
    }

    public function filtrarDespesas(FiltrarDespesasRequest $request) {
        $dados = $request->validated();

        $input = New FiltrarDespesasInput(
            $dados['descricao'] ?? null,
            $dados['mes'] ?? null,
            $dados['data_inicial'] ?? null,
            $dados['data_final'] ?? null
        );

        $output = $this->filtrarDespesas->execute($input);

        return view('index', [
            'despesas' => $output->despesas,
            'total' => $output->total,
            'filtros' => $dados
        ]);
    }

}
