<?php
namespace App\Repositories\Contracts;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryInterface
 */
interface EloquentRepositoryInterface extends RepositoryInterface
{
    public function all();

    public function list(array $queries = [], array $relations = []): array|Collection|LengthAwarePaginator;

    public function store(array $parameters);

    public function find(int $id): ?Model;

    public function show(Model $model): Model;

    public function update(Model $model, array $parameters);

    public function createOrUpdate(array $parameters, $id = null);

    public function destroy(Model $model): bool;
}
