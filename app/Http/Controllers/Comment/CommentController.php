<?php

namespace App\Http\Controllers\Comment;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CommentController extends ApiController
{
    public function index()
    {
        $comments = Comment::all();

        return $this->showAll($comments, 200); // using trait
    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id);

        return $this->showOne($comment, 200); // using trait
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        // $article->forceDelete(); to delete premanently

        return $this->showOne($comment, 200); // using trait
    }
}
