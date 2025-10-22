<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Inputs\AtualizarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\Outputs\AtualizarDespesaOutput;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Core\Modules\Despesas\Domain\Rulesets\DespesaRuleSet;

class AtualizarDespesaUseCase
{
    public function __construct(
        private DespesaGateway $despesaInterface,
        private DespesaRuleSet $despesaRuleSet
    ) {}

    public function execute(AtualizarDespesaInput $input): AtualizarDespesaOutput
    {
        $user = auth()->user()->id;

        $despesa = new DespesaEntity(
            $input->id,
            $input->descricao,
            $input->valor,
            $input->data,
            $user
        );

        $this->despesaRuleSet->apply($despesa);
        $this->despesaInterface->update($despesa);

        return new AtualizarDespesaOutput(
            $despesa->id,
            [
                'descricao' => $despesa->descricao,
                'valor' => $despesa->valor,
                'data' => $despesa->data->format('Y-m-d'),
            ],
            'Despesa atualizada com sucesso'
        );
    }
}
