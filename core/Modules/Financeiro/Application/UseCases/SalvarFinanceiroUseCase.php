<?php

namespace Core\Modules\Financeiro\Application\UseCases;

use Core\Modules\Financeiro\Application\UseCases\Input\FinanceiroInput;
use Core\Modules\Financeiro\Application\UseCases\Output\FinanceiroOutput;
use Core\Modules\Financeiro\Domain\Gateway\FinanceiroGateway;

class SalvarFinanceiroUseCase
{
    public function __construct(
        private FinanceiroGateway $financeiroGateway
    ) {}

    public function execute(FinanceiroInput $financeiroInput): FinanceiroOutput {
        $dadosFinanceiro = [
            'usuarioId' => $financeiroInput->usuarioId,
            'salario' => $financeiroInput->salario,
            'limite' => $financeiroInput->limite,
        ];

        $financeiro = $this->financeiroGateway->salvarFinanceiro($dadosFinanceiro);

        return new FinanceiroOutput(
            $financeiro->salario,
            $financeiro->limite
        );
    }
}
