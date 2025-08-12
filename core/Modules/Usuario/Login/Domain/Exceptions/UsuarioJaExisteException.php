<?php

namespace Core\Modules\Usuario\Login\Domain\Exceptions;

use Exception;

class UsuarioJaExisteException extends Exception
{
    protected $message = 'O e-mail informado ja está cadastrado';
}
