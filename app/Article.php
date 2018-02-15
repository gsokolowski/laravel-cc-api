<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'card_text',
        'text',
        'tags',
        'public',
        'category_id',
        'user_id',
    ];

    // Article belongs to Category
    public function category() {
        return $this->belongsTo('App\Category');
    }

    // Once the relationship has been defined,
    // we can retrieve the Category model for a Article
    // by accessing the category "dynamic property":

    // $article = App\Category::find(1);
    // echo $article->category->title;


    // Article has many comments
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    //  you can get comments like that
    //  $comments = App\Article::find(1)->comments;
    //  foreach ($comments as $comment) {
    //      echo $comment->text;
    //  }

    // Article has many images
    public function images() {
        return $this->hasMany('App\Image');
    }

}
