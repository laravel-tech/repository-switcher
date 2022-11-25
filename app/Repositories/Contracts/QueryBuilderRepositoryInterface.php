<?php
namespace App\Repositories\Contracts;

use App\Repositories\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface QueryBuilderRepositoryInterface
 */
interface QueryBuilderRepositoryInterface extends RepositoryInterface
{
    public function all();

    public function list(array $queries = [], array $relations = []): array|Collection|LengthAwarePaginator;

    public function store(array $parameters);

    public function find(int $id): ?Collection;

    public function show(string $column): ?Collection;

    public function update(string $column, array $parameters);

    public function createOrUpdate(array $parameters, $id = null);

    public function destroy(string $column): bool;
}
