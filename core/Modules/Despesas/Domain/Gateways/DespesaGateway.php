<?php

namespace Core\Modules\Despesas\Domain\Gateways;

use Core\Modules\Despesas\Domain\Entities\DespesaEntity;

interface DespesaGateway
{
    public function salvar(DespesaEntity $despesa): DespesaEntity;
    public function excluir(int $id): bool;
    public function atualizar(DespesaEntity $despesa): DespesaEntity;
    public function listar(): array;
    public function buscar(int $id): ?DespesaEntity;
}
