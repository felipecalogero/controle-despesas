<?php

namespace Core\Modules\Financeiro\Application\UseCases;

use Core\Modules\Financeiro\Application\UseCases\Output\FinanceiroOutput;
use Core\Modules\Financeiro\Domain\Gateway\FinanceiroGateway;

class BuscarConfigFinanceiroUseCase
{
    public function __construct(
        private FinanceiroGateway $financeiroGateway
    ) {}

    public function execute() {
        $usuarioId = auth()->user()->id;

        $configFinanceiro = $this->financeiroGateway->buscarConfigFinanceiro($usuarioId);

        return new FinanceiroOutput(
            $configFinanceiro->salario,
            $configFinanceiro->limite
        );
    }
}
