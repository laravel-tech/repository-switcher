<?php

namespace App\Repositories\QueryBuilder;

use App\Repositories\BaseRepository;
use App\Repositories\Contracts\QueryBuilderRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QueryBuilderRepository extends BaseRepository implements QueryBuilderRepositoryInterface
{
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'NoModel';
    }

    /**
     * Return a table query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getTable(): \Illuminate\Database\Query\Builder
    {
        return DB::table($this->getTableName());
    }

    /**
     * Get route key name.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Apply filters on the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array                                 $queries
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyFilters(Builder $builder, array $queries = []): Builder
    {
        return $builder;
    }

    /**
     * Get all resources.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->getTable()->get();
    }

    /**
     * Get all resources filtered and sorted.
     *
     * @param array $queries
     * @param array $relations
     *
     * @return array|\Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $queries = [], array $relations = []): array|Collection|LengthAwarePaginator
    {
        $builder = $this->getTable();
        if(isset($relations)) {
            foreach ($relations as $relation) {
                $builder->join($relation,$this->getTableName() . '.id','=', $relation . Str::singular($this->getTableName()) . '_id');
            }
        }
        $builder = $this->applyFilters($builder, $queries);
        $builder = $builder->orderBy('created_at', $queries['order_by'] ?? 'DESC');
        return (isset($queries['paginate']) && $queries['paginate']) ? $builder->paginate() : $builder->get();
    }

    /**
     * Store a new resource.
     *
     * @param array $parameters
     *
     * @return \Illuminate\Support\Collection
     */
    public function store(array $parameters): Collection
    {
        $parameters['created_at'] = now();
        $parameters['updated_at'] = now();
        return collect($this->getTable()->insert($parameters));
    }

    /**
     * Get a resource via its id.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): ?Collection
    {
        return collect($this->getTable()->find($id));
    }

    /**
     * Get a resource.
     *
     * @param string $column
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function show(string $column): ?Collection
    {
        return collect($this->getTable()->where($this->getRouteKeyName(), $column)->first());
    }

    /**
     * Update a specific resource.
     *
     * @param string $column
     * @param array  $parameters
     *
     * @return \Illuminate\Support\Collection
     */
    public function update(string $column, array $parameters): Collection
    {
        $this->getTable()->where($this->getRouteKeyName(), $column)->update($parameters);
        return $this->getTable()->where($this->getRouteKeyName(), $column)->first();
    }

    /**
     * Update an existing resource or create it if not exist.
     *
     * @param array $parameters
     * @param null  $id
     *
     * @return \Illuminate\Support\Collection
     */
    public function createOrUpdate(array $parameters, $id = null): Collection
    {
        return is_null($id) ? $this->store($parameters) : $this->update('id', $parameters);
    }

    /**
     * Deletes a specific resource.
     *
     * @param string $column
     *
     * @return bool
     */
    public function destroy(string $column): bool
    {
        return $this->getTable()->where($this->getRouteKeyName(), $column)->delete();
    }
}
