<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'text',
        'public',
        'user_id',
        'article_id'
    ];

    // Comment belongs to User
    public function user() {
        return $this->belongsTo('App\User');
    }

    // Comment belongs to Article
    public function article() {
        return $this->belongsTo('App\Article');
    }

    // Once the relationship has been defined,
    // we can retrieve the Article model for a Comment
    // by accessing the article "dynamic property":

    // $comment = App\Article::find(1);
    // echo $comment->article->title;

}
