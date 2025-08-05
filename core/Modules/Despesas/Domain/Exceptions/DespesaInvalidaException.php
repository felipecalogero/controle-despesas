<?php

namespace Core\Modules\Despesas\Domain\Exceptions;

use Exception;

class DespesaInvalidaException extends Exception
{
    protected $message = 'A despesa informada não existe.';
}
