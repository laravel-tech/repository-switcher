<?php

namespace App\Repositories\QueryBuilder;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Database\Query\Builder;

class ArticleRepository extends QueryBuilderRepository implements ArticleRepositoryInterface
{
    /**
     * Return Article model namespace.
     *
     * @return string
     */
    public function getTableName(): string
    {
        return 'articles';
    }

    /**
     * Get route key name.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Apply filters on the model.
     *
     * @param \Illuminate\Database\Query\Builder $builder
     * @param array                                 $queries
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function applyFilters(Builder $builder, array $queries = []): Builder
    {
        return parent::applyFilters($builder, $queries);
    }

    /**
     * Find an article by slug.
     *
     * @param string $slug
     *
     * @return \Illuminate\Database\Query\Builder|object|null
     */
    public function findBySlug(string $slug)
    {
        return $this->getTable()->where('slug', $slug)->first();
    }
}
