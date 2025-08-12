<?php

namespace Core\Modules\Usuario\Login\Domain\Exceptions;

use Exception;

class UsuarioNaoEncontradoException extends Exception
{
    protected $message = 'Usuário informado não foi encontrado.';
}
