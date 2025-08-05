<?php

namespace App\Infrastructure\Repositories;

use App\Core\Modules\Despesas\Domain\Exceptions\DespesaInvalidaException;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use App\Models\Despesa;

class QueryDespesaRepository implements DespesaGateway
{
    public function salvar(DespesaEntity $despesa): DespesaEntity
    {
        $despesaModel = new Despesa();
        $despesaModel->id = $despesa->id;
        $despesaModel->descricao = $despesa->descricao;
        $despesaModel->valor = $despesa->valor;
        $despesaModel->data = $despesa->data->format('Y-m-d');
        $despesaModel->save();

        return new DespesaEntity(
            $despesaModel->id,
            $despesaModel->descricao,
            $despesaModel->valor,
            new \DateTime($despesaModel->data),
        );
    }

    public function excluir(int $id): bool
    {
        $despesa = Despesa::query()->findOrFail($id);

        if (!$despesa) {
            return false;
        }

        $despesa->delete();
        return true;
    }

    public function atualizar(DespesaEntity $despesa): DespesaEntity
    {
        $despesaModel = Despesa::query()->findOrFail($despesa->id);

        $despesaModel->descricao = $despesa->descricao;
        $despesaModel->valor = $despesa->valor;
        $despesaModel->data = $despesa->data->format('Y-m-d');

        $despesaModel->save();

        return new DespesaEntity(
            $despesaModel->id,
            $despesaModel->descricao,
            $despesaModel->valor,
            new \DateTime($despesaModel->data)
        );
    }


    public function listar(): array
    {
        return Despesa::query()
            ->orderBy('data')
            ->get()
            ->map(function ($despesaModel) {
                return new DespesaEntity(
                    $despesaModel->id,
                    $despesaModel->descricao,
                    $despesaModel->valor,
                    new \DateTime($despesaModel->data),
                );
            })
            ->toArray();
    }

    public function buscar(int $id): DespesaEntity
    {
        $despesa = Despesa::query()->findOrFail($id);

        if (!$despesa) {
            throw new DespesaInvalidaException('Despesa inválida.');
        }

        return new DespesaEntity(
            $despesa->id,
            $despesa->descricao,
            $despesa->valor,
            new \DateTime($despesa->data),
            $despesa->created_at,
            $despesa->updated_at,
        );
    }
}
