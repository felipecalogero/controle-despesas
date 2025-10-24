<?php

namespace Core\Modules\Usuario\Cadastro\Domain\Gateways;

use Core\Modules\Usuario\Domain\Entities\UsuarioEntity;

interface CadastroGateway
{
    public function saveUser(string $name, string $lastName, string $email, string $password): UsuarioEntity;
    public function deleteUser(int $id): bool;
    public function updateUser(UsuarioEntity $user): UsuarioEntity;
    public function getUser(string $email): ?UsuarioEntity;
}
