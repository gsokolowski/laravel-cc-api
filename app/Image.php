<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'image',
        'caption',
        'type', // hero, card, in text image
        'article_id' // foreign key to table article
    ];
}
