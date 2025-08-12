<?php

namespace Core\Modules\Usuario\Cadastro\Application\Domain\Gateways;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface CadastroGateway
{
    public function salvar(UsuarioEntity $user): UsuarioEntity;
    public function excluir(int $id): bool;
    public function atualizar(UsuarioEntity $user): UsuarioEntity;
    public function buscarUsuario(string $email): ?UsuarioEntity;
}
