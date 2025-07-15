<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Outputs\ListarDespesasOutput;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class ListarDespesasUseCase
{
    public function __construct(private DespesaGateway $despesaInterface){}

    public function execute(): ListarDespesasOutput
    {
        $despesas  = $this->despesaInterface->listar();
        $total = $this->calcularValorTotal($despesas);

        return new ListarDespesasOutput(
            $despesas,
            $total
        );
    }

    public function calcularValorTotal($despesas): float
    {
        return array_reduce($despesas, fn($acc, $d) => $acc + $d->valor, 0);
    }
}
