<?php

namespace App\Infrastructure\Repositories;

use App\Core\Modules\Despesas\Domain\Exceptions\DespesaInvalidaException;
use App\Http\Requests\FiltrarDespesasRequest;
use Core\Modules\Despesas\Application\UseCases\Inputs\FiltrarDespesasInput;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use App\Models\Despesa;

class QueryDespesaRepository implements DespesaGateway
{
    public function save(DespesaEntity $despesa): DespesaEntity
    {
        $usuarioId = auth()->user()->id;

        $despesaModel = new Despesa();
        $despesaModel->id = $despesa->id;
        $despesaModel->descricao = $despesa->descricao;
        $despesaModel->valor = $despesa->valor;
        $despesaModel->data = $despesa->data->format('Y-m-d');
        $despesaModel->user_id = $usuarioId;
        $despesaModel->save();

        return new DespesaEntity(
            id: $despesaModel->id,
            descricao: $despesaModel->descricao,
            valor: $despesaModel->valor,
            data: new \DateTime($despesaModel->data),
            usuarioId: $usuarioId
        );
    }

    public function delete(int $id): bool
    {
        $despesa = Despesa::query()->findOrFail($id);

        if (!$despesa) {
            return false;
        }

        $despesa->delete();
        return true;
    }

    public function update(DespesaEntity $despesa): DespesaEntity
    {
        $despesaAtualizada = Despesa::query()->findOrFail($despesa->id);

        $despesaAtualizada->descricao = $despesa->descricao;
        $despesaAtualizada->valor = $despesa->valor;
        $despesaAtualizada->data = $despesa->data->format('Y-m-d');
        $despesaAtualizada->updated_at = now()->format('Y-m-d');

        $despesaAtualizada->save();

        return new DespesaEntity(
            id: $despesaAtualizada->id,
            descricao: $despesaAtualizada->descricao,
            valor: $despesaAtualizada->valor,
            data: new \DateTime($despesaAtualizada->data),
            usuarioId: $despesaAtualizada->user_id,
            updatedAt: $despesaAtualizada->updated_at
        );
    }


    public function list(): array
    {
        $usuarioId = auth()->user()->id;

        return Despesa::query()
            ->orderBy('data')
            ->where('user_id', $usuarioId)
            ->get()
            ->map(function ($despesaModel) {
                return new DespesaEntity(
                    id: $despesaModel->id,
                    descricao: $despesaModel->descricao,
                    valor: $despesaModel->valor,
                    data: new \DateTime($despesaModel->data),
                    usuarioId: $despesaModel->user_id
                );
            })
            ->toArray();
    }

    public function getById(int $id): DespesaEntity
    {
        $despesa = Despesa::query()->findOrFail($id);

        if (!$despesa) {
            throw new \Core\Modules\Despesas\Domain\Exceptions\DespesaInvalidaException('Despesa inválida.');
        }

        return new DespesaEntity(
            id: $despesa->id,
            descricao: $despesa->descricao,
            valor: $despesa->valor,
            data: new \DateTime($despesa->data),
            usuarioId: $despesa->user_id,
            createdAt: $despesa->created_at,
            updatedAt: $despesa->updated_at,
        );
    }

    public function filterDespesas(FiltrarDespesasInput $despesasInput): array
    {
        $usuarioId = auth()->user()->id;

        $query = Despesa::query()->where('user_id', $usuarioId); // ← Adiciona aqui

        if(!empty($despesasInput->descricao)){
            $query->where('descricao', 'like', '%'.$despesasInput->descricao.'%');
        }

        if(!empty($despesasInput->mes)){
            $query->whereMonth('data', $despesasInput->mes);
        }

        if(!empty($despesasInput->dataInicial)){
            $query->whereDate('data', '>=', $despesasInput->dataInicial);
        }

        if(!empty($despesasInput->dataFinal)){
            $query->whereDate('data', '<=', $despesasInput->dataFinal);
        }

        return $query
            ->orderBy('data')
            ->get()
            ->map(fn($model) => new DespesaEntity(
                id: $model->id,
                descricao: $model->descricao,
                valor: $model->valor,
                data: new \DateTime($model->data),
                usuarioId: $model->user_id
            ))
            ->toArray();
    }

    public function getTotal($despesas): float
    {
        return array_reduce($despesas, fn($acc, $d) => $acc + $d->valor, 0);
    }
}
