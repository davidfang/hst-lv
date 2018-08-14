<?php

namespace App\Http\Controllers\Api;

use App\Model\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Circle as CircleResource;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * 列出分类下的文章
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id)
    {
        $article = Article::where([['status','1'],['category_id',$category_id]])->paginate();
        return $this->success(ArticleResource::collection($article));
        //
    }

    /**
     * 圈子 分类ID为5
     * @return mixed
     */
    public function circle(Request $request)
    {
        $category_id = $request->get('category_id',5);
        $article = Article::where([['status','1'],['category_id',$category_id]])->paginate();
        return $this->success(CircleResource::collection($article));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $this->success(new ArticleResource($article));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
