<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// this is access to user with middlewere added on project generation
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::resource('users', 'User\UserController', ['except'=>['create', 'edit']] );
Route::name('users.verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('users.resent')->get('users/{user}/resend', 'User\UserController@resend');


Route::resource('categories', 'Category\CategoryController', ['except'=>['create', 'edit']] );
Route::resource('articles', 'Article\ArticleController', ['only'=>['index', 'show', 'destroy']] );
Route::resource('images', 'Image\ImageController', ['only'=>['index', 'show', 'destroy']] );
Route::resource('comments', 'Comment\CommentController', ['only'=>['index', 'show', 'destroy']] );


/**
 *
 * greg:laravel-cc-api Grzegorz$ php artisan route:list
+--------+-----------+---------------------------+--------------------+----------------------------------------------------------+------------+
| Domain | Method    | URI                       | Name               | Action                                                   | Middleware |
+--------+-----------+---------------------------+--------------------+----------------------------------------------------------+------------+
|        | GET|HEAD  | /                         |                    | Closure                                                  | web        |
|        | GET|HEAD  | api/articles              | articles.index     | App\Http\Controllers\Article\ArticleController@index     | api        |
|        | GET|HEAD  | api/articles/{article}    | articles.show      | App\Http\Controllers\Article\ArticleController@show      | api        |
|        | DELETE    | api/articles/{article}    | articles.destroy   | App\Http\Controllers\Article\ArticleController@destroy   | api        |
|        | POST      | api/categories            | categories.store   | App\Http\Controllers\Category\CategoryController@store   | api        |
|        | GET|HEAD  | api/categories            | categories.index   | App\Http\Controllers\Category\CategoryController@index   | api        |
|        | PUT|PATCH | api/categories/{category} | categories.update  | App\Http\Controllers\Category\CategoryController@update  | api        |
|        | DELETE    | api/categories/{category} | categories.destroy | App\Http\Controllers\Category\CategoryController@destroy | api        |
|        | GET|HEAD  | api/categories/{category} | categories.show    | App\Http\Controllers\Category\CategoryController@show    | api        |
|        | GET|HEAD  | api/comments              | comments.index     | App\Http\Controllers\Comment\CommentController@index     | api        |
|        | DELETE    | api/comments/{comment}    | comments.destroy   | App\Http\Controllers\Comment\CommentController@destroy   | api        |
|        | GET|HEAD  | api/comments/{comment}    | comments.show      | App\Http\Controllers\Comment\CommentController@show      | api        |
|        | GET|HEAD  | api/images                | images.index       | App\Http\Controllers\Image\ImageController@index         | api        |
|        | DELETE    | api/images/{image}        | images.destroy     | App\Http\Controllers\Image\ImageController@destroy       | api        |
|        | GET|HEAD  | api/images/{image}        | images.show        | App\Http\Controllers\Image\ImageController@show          | api        |
|        | POST      | api/users                 | users.store        | App\Http\Controllers\User\UserController@store           | api        |
|        | GET|HEAD  | api/users                 | users.index        | App\Http\Controllers\User\UserController@index           | api        |
|        | PUT|PATCH | api/users/{user}          | users.update       | App\Http\Controllers\User\UserController@update          | api        |
|        | GET|HEAD  | api/users/{user}          | users.show         | App\Http\Controllers\User\UserController@show            | api        |
|        | DELETE    | api/users/{user}          | users.destroy      | App\Http\Controllers\User\UserController@destroy         | api        |
+--------+-----------+---------------------------+--------------------+----------------------------------------------------------+------------+
 * */