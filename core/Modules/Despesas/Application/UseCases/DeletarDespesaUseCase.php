<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Outputs\DeletarDespesaOutput;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class DeletarDespesaUseCase
{
    public function __construct(private DespesaGateway $despesaInterface){}

    public function execute(int $id): DeletarDespesaOutput
    {
        $sucesso = $this->despesaInterface->excluir($id);

        return new DeletarDespesaOutput(
            $sucesso,
            'Despesa excluida com sucesso!'
        );
    }
}
