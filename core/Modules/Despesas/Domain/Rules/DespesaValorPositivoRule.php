<?php

namespace Core\Modules\Despesas\Domain\Rules;

use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Exceptions\DespesaValorNegativoException;

class DespesaValorPositivoRule
{
    public function apply(DespesaEntity $despesa): void
    {
        if ($despesa->getValor() <= 0.00) {
            throw new DespesaValorNegativoException();
        }
    }
}
