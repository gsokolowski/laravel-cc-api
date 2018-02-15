<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    // pomysl jak zrobic self referencing categiries
    // dodajac field parent_id ktore powinno wskazywac paren child category
    // gosciu wyjasnia
    // https://laracasts.com/discuss/channels/laravel/create-a-nested-lists-of-categories-in-laravel-5?page=1

    protected $fillable = [
        'name',
        'description',
        'parent_id' // 0 is main category if number other then 0 this is a child of category parent id
    ];

    // category has many articles
    public function articles() {

        return $this->hasMany('App\Article');
    }

    //  you can get articles like that
    //  $articles = App\Comment::find(1)->articles;
    //  foreach ($articles as $article) {
    //      echo $article->title;
    //  }
}
