<?php

namespace Core\Modules\Despesas\Application\UseCases;

use Core\Modules\Despesas\Application\UseCases\Inputs\CriarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\Outputs\CriarDespesaOutput;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Core\Modules\Despesas\Domain\Rulesets\DespesaRuleSet;

class CriarDespesaUseCase
{
    public function __construct(
        private DespesaGateway $despesaInterface,
        private DespesaRuleSet $despesaRuleSet
    ) {}

    public function execute(CriarDespesaInput $input): CriarDespesaOutput
    {
        $despesa = new DespesaEntity(
            null,
            $input->descricao,
            $input->valor,
            $input->data
        );

        $this->despesaRuleSet->apply($despesa);
        $despesaSalva = $this->despesaInterface->salvar($despesa);

        return new CriarDespesaOutput(
            $despesaSalva->id,
            [
                'descricao' => $despesaSalva->descricao,
                'valor' => $despesaSalva->valor,
                'data' => $despesaSalva->data->format('Y-m-d'),
            ],
            'Despesa criada com sucesso.'
        );
    }
}
