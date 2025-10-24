<?php

namespace App\Infrastructure\Repositories;

use App\Models\Financeiro;
use App\Models\User;
use Core\Modules\Financeiro\Application\UseCases\Input\FinanceiroInput;
use Core\Modules\Financeiro\Domain\Entities\FinanceiroEntity;
use Core\Modules\Financeiro\Domain\Gateway\FinanceiroGateway;
use Core\Modules\Usuario\Application\UseCases\Input\SalvarSalarioInput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

class QueryFinanceiroRepository implements FinanceiroGateway
{
    public function salvarFinanceiro(array $dadosFinanceiro): FinanceiroEntity
    {
        $userId = $dadosFinanceiro['usuarioId'];

        $financeiro = Financeiro::updateOrCreate(
            ['user_id' => $userId],
            [
                'user_id' => $userId,
                'salary' => $dadosFinanceiro['salario'],
                'limit_spend' => $dadosFinanceiro['limite']
            ]
        );

        return new FinanceiroEntity(
            $financeiro->id,
            $financeiro->salary,
            $financeiro->limit_spend,
        );
    }

    public function buscarConfigFinanceiro(int $usuarioId): ?FinanceiroEntity
    {
        $configFinanceiro = Financeiro::query()->where('user_id', $usuarioId)->first();

        if (!$configFinanceiro) {
            return null;
        }

        return new FinanceiroEntity(
            $configFinanceiro->user_id,
            $configFinanceiro->salary,
            $configFinanceiro->limit_spend
        );
    }
}
