# repository-switcher
A repository pattern example for laravel to switch between eloquent and query builder.

## Steps

1. Define repository classes and interfaces in `app\Repositories` directory.
2. Define a constructor in all controllers:<br>
`
   public function __construct(StrategyContext $strategy)
   {
      parent::__construct($strategy);
      $this->strategy->repository(ArticleRepositoryInterface::class);
   }
`
3. Call method of the repository like the following example:<br>
`$querybuilderData = $this->strategy->querybuilder()->list();`<br>
OR<br>
`$eloquentData = $this->strategy->eloquent()->list();`
