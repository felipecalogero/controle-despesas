<?php

namespace Core\Modules\Despesas\Domain\Exceptions;

use Exception;

class DespesaNaoPodeSerFuturaException extends Exception
{
    protected $message = 'A data da despesa não pode ser futura.';
}
