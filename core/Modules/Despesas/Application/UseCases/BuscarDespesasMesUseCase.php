<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Outputs\ListarDespesasOutput;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class BuscarDespesasMesUseCase
{
    public function __construct(
        private DespesaGateway $despesaInterface
    ) {}

    public function execute() {
        $despesasMes = $this->despesaInterface->getDespesasMonth();
        $total = $this->despesaInterface->getTotal($despesasMes);

        return new ListarDespesasOutput(
            $despesasMes,
            $total
        );
    }
}
