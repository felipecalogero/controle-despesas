<?php

namespace Core\Modules\Despesas\Domain\Rules;

use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Exceptions\DespesaNaoPodeSerFuturaException;
use DateTime;

class DespesaNaoPodeSerFuturaRule
{
    public function apply(DespesaEntity $despesa): void
    {
        $hoje = new DateTime();

        if ($despesa->getData() > $hoje) {
            throw new DespesaNaoPodeSerFuturaException();
        }
    }
}

