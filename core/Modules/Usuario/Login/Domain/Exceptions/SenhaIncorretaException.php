<?php

namespace Core\Modules\Usuario\Login\Domain\Exceptions;

use Exception;

class SenhaIncorretaException extends Exception
{
    protected $message = 'A senha informada está incorreta!';
}
