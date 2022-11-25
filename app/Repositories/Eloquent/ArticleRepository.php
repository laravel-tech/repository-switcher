<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface
{
    /**
     * Return Article model namespace.
     *
     * @return string
     */
    public function getModelName(): string
    {
        return Article::class;
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
        return new ArticleResource($model);
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
        return new ArticleCollection($collection);
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
        return parent::applyFilters($builder, $queries);
    }

	/**
	 * Find an article by slug.

	 * @param string $slug
	 * @return Article
	 */
	public function findBySlug(string $slug): Article
	{
		return $this->getModel()->whereSlug($slug)->firstOrFail();
	}
}
