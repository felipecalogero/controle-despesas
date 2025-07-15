<?php

namespace Core\Modules\Despesas\Domain\Exceptions;

use Exception;

class DespesaValorNegativoException extends Exception
{
    protected $message = 'O valor da despesa deve ser positivo.';
}
