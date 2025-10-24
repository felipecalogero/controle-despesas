<?php

namespace Core\Modules\Financeiro\Domain\Gateway;

use Core\Modules\Financeiro\Application\UseCases\Input\FinanceiroInput;
use Core\Modules\Financeiro\Application\UseCases\Output\FinanceiroOutput;
use Core\Modules\Financeiro\Domain\Entities\FinanceiroEntity;
use Core\Modules\Usuario\Application\UseCases\Input\SalvarSalarioInput;

interface FinanceiroGateway
{
    public function salvarFinanceiro(array $dadosFinanceiro): FinanceiroEntity;
    public function buscarConfigFinanceiro(int $usuarioId): ?FinanceiroEntity;
}
