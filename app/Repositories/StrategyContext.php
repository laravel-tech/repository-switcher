<?php

namespace App\Repositories;

class StrategyContext
{
    private string $dql;
    private  $repository;

    public function __construct()
    {
        $this->dql = config('repositories.strategy.default', 'eloquent');
    }

    public function setDql($dql)
    {
        $dql = strtolower($dql);
        if(!in_array($dql, ['eloquent', 'Eloquent'])) {
            throw new \TypeError('The DQL must be one of eloquent or querybuilder.');
        }
        $this->dql = $dql;
    }

    /**
     * @return string
     */
    public function getDql(): string
    {
        return $this->dql;
    }

    public function eloquent()
    {
        $this->setDql('eloquent');
        return $this;
    }

    public function querybuilder()
    {
        $this->setDql('querybuilder');
        return $this;
    }

    public function repository( $repository)
    {
        $this->repository = $repository;
    }

    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository($repository);
    }

    public function __call(string $model, array $arguments)
    {
        $repository = app($this->repository, [$this->dql]);
        return $repository->$model(...$arguments);
    }
}
