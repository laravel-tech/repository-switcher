<?php

namespace App\Repositories\Contracts;

use App\Models\Article;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface ArticleReposInterface
 */
interface ArticleRepositoryInterface extends RepositoryInterface
{
	public function findBySlug(string $slug);
}
