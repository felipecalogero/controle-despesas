<?php

namespace Core\Modules\Usuario\Domain\Gateway;

use Core\Modules\Usuario\Application\UseCases\Input\AlterarSenhaInput;
use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface UsuarioGateway
{
    public function atualizarSenha(int $usuarioId, string $novaSenhaHash): bool;
    public function buscarUsuarioId(int $usuarioId): ?UsuarioEntity;
}
