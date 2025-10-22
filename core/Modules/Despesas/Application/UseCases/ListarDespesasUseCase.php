<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Outputs\ListarDespesasOutput;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class ListarDespesasUseCase
{
    public function __construct(private DespesaGateway $despesaInterface){}

    public function execute(): ListarDespesasOutput
    {
        $despesas  = $this->despesaInterface->list();
        $total = $this->despesaInterface->getTotal($despesas);

        return new ListarDespesasOutput(
            $despesas,
            $total
        );
    }
}
