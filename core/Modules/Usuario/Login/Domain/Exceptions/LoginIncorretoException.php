<?php

namespace Core\Modules\Usuario\Login\Domain\Exceptions;

use Exception;

class LoginIncorretoException extends Exception
{
    protected $message =  'Usuário ou senha incorretos.';
}
