<?php

namespace Core\Modules\Despesas\Domain\Gateways;

use Core\Modules\Despesas\Application\UseCases\Inputs\FiltrarDespesasInput;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;

interface DespesaGateway
{
    public function save(DespesaEntity $despesa): DespesaEntity;
    public function delete(int $id): bool;
    public function update(DespesaEntity $despesa): DespesaEntity;
    public function list(): array;
    public function getById(int $id): ?DespesaEntity;
    public function filterDespesas(array $filtros): array;
    public function getTotal(array $despesas);
    public function getDespesasMonth(): array;
}
