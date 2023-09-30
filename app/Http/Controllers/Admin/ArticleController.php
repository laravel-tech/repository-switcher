<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\StrategyContext;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(StrategyContext $strategy)
    {
        parent::__construct($strategy);
        $this->strategy->repository(ArticleRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     * You can get a list of data using one of the following ways:
     * return $this->strategy->querybuilder()->list();
     * return $this->strategy->eloquent()->list();
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->strategy->eloquent()->list();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\ArticleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        return $this->strategy->eloquent()->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        return $this->strategy->eloquent()->findBySlug($slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\ArticleRequest $request
     * @param int                                     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        return $this->strategy->eloquent()->update($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->strategy->eloquent()->destroy($id);
    }
}
