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

    // POST http://127.0.0.1:8000/api/users + data for each fields
    public function store(Request $request)
    {
        $data['images'] = $request->images->store('', 'images-article');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        // $article->forceDelete(); to delete premanently

        return $this->showOne($article, 200); // using trait
    }
}
