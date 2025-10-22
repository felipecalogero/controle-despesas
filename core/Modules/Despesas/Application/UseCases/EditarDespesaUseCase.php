<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Outputs\EditarDespesaOutput;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;

class EditarDespesaUseCase
{
    public function __construct(private DespesaGateway $despesaInterface)
    {}

    public function execute(int $id): EditarDespesaOutput
    {
        $despesa = $this->despesaInterface->getById($id);

        return new EditarDespesaOutput(
            $despesa->id,
            $despesa->descricao,
            $despesa->valor,
            $despesa->data,
            $despesa->createdAt,
            $despesa->updatedAt
        );
    }
}
