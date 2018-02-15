<?php

namespace App\Http\Controllers\Article;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class ArticleController extends ApiController
{
    public function index()
    {
        $articles = Article::all();

        return $this->showAll($articles, 200); // using trait
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        return $this->showOne($article, 200); // using trait
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        // $article->forceDelete(); to delete premanently

        return $this->showOne($article, 200); // using trait
    }
}
