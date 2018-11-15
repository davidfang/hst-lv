<?php

namespace App\Http\Controllers;

use App\Model\Article;
use App\Model\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id)
    {
        //$category_id = $request->get('category_id',1);
        $category = ArticleCategory::find($category_id);
        $article = Article::where([['status', '1'], ['category_id', $category_id]])->paginate();
        return view('article', ['articles' => $article, 'category' => $category]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article,Request $request)
    {
        if($request->get('appName')){
            $article->body = str_replace(config('app.name'),$request->get('appName'),$article->body);
        }
        if (empty($article->view)) {
            return view('article-detail', ['article' => $article]);
        } else {
            return view($article->view, ['article' => $article]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Model\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
