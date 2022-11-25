<?php

namespace App\Providers;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Eloquent\ArticleRepository as EloquentArticleRepository;
use App\Repositories\QueryBuilder\ArticleRepository as QueryBuilderArticleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleRepositoryInterface::class, function ($app, $dql) {
            return match ($dql[0]) {
                'querybuilder', 'QueryBuilder'  => new QueryBuilderArticleRepository(),
                'eloquent', 'Eloquent'          => new EloquentArticleRepository(),
                default                         => new EloquentArticleRepository(),
            };
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
