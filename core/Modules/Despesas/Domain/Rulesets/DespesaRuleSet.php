<?php

namespace Core\Modules\Despesas\Domain\Rulesets;

use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Rules\DespesaNaoPodeSerFuturaRule;
use Core\Modules\Despesas\Domain\Rules\DespesaValorPositivoRule;

class DespesaRuleSet
{
    public function __construct(
        private DespesaNaoPodeSerFuturaRule $despesaDataPassada,
        private DespesaValorPositivoRule $despesaValorPositivo
    ) {}

    public function apply(DespesaEntity $despesa): void
    {
        $this->despesaValorPositivo->apply($despesa);
        $this->despesaDataPassada->apply($despesa);
    }
}
