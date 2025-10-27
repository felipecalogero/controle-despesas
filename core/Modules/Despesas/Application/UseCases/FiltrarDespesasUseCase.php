<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Inputs\FiltrarDespesasInput;
use Core\Modules\Despesas\Application\UseCases\Outputs\FiltrarDespesasOutput;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class FiltrarDespesasUseCase
{
    public function __construct(
        private DespesaGateway $despesaInterface
    ) {}

    public function execute(FiltrarDespesasInput $despesasInput): FiltrarDespesasOutput
    {
        $filtros = [
            'descricao' => $despesasInput->descricao,
            'mes' => $despesasInput->mes,
            'data_inicial' => $despesasInput->dataInicial,
            'data_final' => $despesasInput->dataFinal,
        ];

        $despesas = $this->despesaInterface->filterDespesas($filtros);
        $total = $this->despesaInterface->getTotal($despesas);

        return new FiltrarDespesasOutput(
            $despesas,
            $total
        );
    }
}

