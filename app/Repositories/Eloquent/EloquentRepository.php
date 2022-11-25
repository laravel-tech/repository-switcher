<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use App\Repositories\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentRepository extends BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return 'NoModel';
	}

    /**
     * Resolve and return a model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel(): Model
    {
        return app($this->getModelName());
    }

    /**
     * Return a json resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function toResource(Model $model): JsonResource
    {
        return new JsonResource($model);
    }

    /**
     * Return a resource collection.
     *
     * @param \Illuminate\Support\Collection $collection
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function toCollection(Collection $collection): ResourceCollection
    {
        return new ResourceCollection($collection);
    }

    /**
     * Return a json response of data and meta.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model $rawData
     *
     * @return array
     */
    public function toJson(LengthAwarePaginator|Collection|Model $rawData): array
    {
        $data = [];
        $meta = [];

        if($rawData instanceof Model) {
            $data = $this->toResource($rawData);
        } elseif($rawData instanceof Collection) {
            $data = $this->toCollection($rawData);
        } elseif($rawData instanceof LengthAwarePaginator) {
            $data = $this->toCollection(collect($rawData->items()));
            $meta = $rawData->toArray();
            unset($meta['data']);
        }

        return compact('data', 'meta');
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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->getModel()->all();
    }

    /**
     * Get all resources filtered and sorted.
     *
     * @param array $queries
     * @param array $relations
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(array $queries = [], array $relations = []): array|\Illuminate\Database\Eloquent\Collection|LengthAwarePaginator
    {
        $builder = $this->getModel()->with($relations);
        $builder = $this->applyFilters($builder, $queries);
        $builder = $builder->orderBy('created_at', $queries['order_by'] ?? 'DESC');
        return (isset($queries['paginate']) && $queries['paginate']) ? $builder->paginate() : $builder->get();
    }

    /**
     * Store a new resource.
     *
     * @param array $parameters
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $parameters): Model
    {
        return $this->getModel()->create($parameters);
    }

    /**
     * Get a resource via its id.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Get a resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show(Model $model): Model
    {
        return $model;
    }

    /**
     * Update a specific resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $parameters
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Model $model, array $parameters): Model
    {
        $model->update($parameters);
        return $model->refresh();
    }

    /**
     * Update an existing resource or create it if not exist.
     *
     * @param array $parameters
     * @param null  $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createOrUpdate(array $parameters, $id = null): Model
    {
        return is_null($id) ? $this->getModel()->create($parameters) : $this->getModel()->where('id', $id)->update($parameters);
    }

    /**
     * Deletes a specific resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    public function destroy(Model $model): bool
    {
        return $model->delete();
    }
}
