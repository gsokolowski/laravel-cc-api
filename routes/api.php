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


Route::resource('users', 'User\UserController');
Route::resource('roles', 'Role\RoleController');
Route::resource('categories', 'Category\CategoryController');
Route::resource('articles', 'Article\ArticleController');
Route::resource('images', 'Image\ImageController');
Route::resource('comments', 'Comment\CommentController');


/**
 *
 * greg:laravel-cc-api Grzegorz$ php artisan route:list
+--------+-----------+--------------------------------+--------------------+----------------------------------------------------------+------------+
| Domain | Method    | URI                            | Name               | Action                                                   | Middleware |
+--------+-----------+--------------------------------+--------------------+----------------------------------------------------------+------------+
|        | GET|HEAD  | /                              |                    | Closure                                                  | web        |
|        | POST      | api/articles                   | articles.store     | App\Http\Controllers\Article\ArticleController@store     | api        |
|        | GET|HEAD  | api/articles                   | articles.index     | App\Http\Controllers\Article\ArticleController@index     | api        |
|        | GET|HEAD  | api/articles/create            | articles.create    | App\Http\Controllers\Article\ArticleController@create    | api        |
|        | PUT|PATCH | api/articles/{article}         | articles.update    | App\Http\Controllers\Article\ArticleController@update    | api        |
|        | GET|HEAD  | api/articles/{article}         | articles.show      | App\Http\Controllers\Article\ArticleController@show      | api        |
|        | DELETE    | api/articles/{article}         | articles.destroy   | App\Http\Controllers\Article\ArticleController@destroy   | api        |
|        | GET|HEAD  | api/articles/{article}/edit    | articles.edit      | App\Http\Controllers\Article\ArticleController@edit      | api        |
|        | GET|HEAD  | api/categories                 | categories.index   | App\Http\Controllers\Category\CategoryController@index   | api        |
|        | POST      | api/categories                 | categories.store   | App\Http\Controllers\Category\CategoryController@store   | api        |
|        | GET|HEAD  | api/categories/create          | categories.create  | App\Http\Controllers\Category\CategoryController@create  | api        |
|        | DELETE    | api/categories/{category}      | categories.destroy | App\Http\Controllers\Category\CategoryController@destroy | api        |
|        | GET|HEAD  | api/categories/{category}      | categories.show    | App\Http\Controllers\Category\CategoryController@show    | api        |
|        | PUT|PATCH | api/categories/{category}      | categories.update  | App\Http\Controllers\Category\CategoryController@update  | api        |
|        | GET|HEAD  | api/categories/{category}/edit | categories.edit    | App\Http\Controllers\Category\CategoryController@edit    | api        |
|        | POST      | api/comments                   | comments.store     | App\Http\Controllers\Comment\CommentController@store     | api        |
|        | GET|HEAD  | api/comments                   | comments.index     | App\Http\Controllers\Comment\CommentController@index     | api        |
|        | GET|HEAD  | api/comments/create            | comments.create    | App\Http\Controllers\Comment\CommentController@create    | api        |
|        | DELETE    | api/comments/{comment}         | comments.destroy   | App\Http\Controllers\Comment\CommentController@destroy   | api        |
|        | PUT|PATCH | api/comments/{comment}         | comments.update    | App\Http\Controllers\Comment\CommentController@update    | api        |
|        | GET|HEAD  | api/comments/{comment}         | comments.show      | App\Http\Controllers\Comment\CommentController@show      | api        |
|        | GET|HEAD  | api/comments/{comment}/edit    | comments.edit      | App\Http\Controllers\Comment\CommentController@edit      | api        |
|        | POST      | api/images                     | images.store       | App\Http\Controllers\Image\ImageController@store         | api        |
|        | GET|HEAD  | api/images                     | images.index       | App\Http\Controllers\Image\ImageController@index         | api        |
|        | GET|HEAD  | api/images/create              | images.create      | App\Http\Controllers\Image\ImageController@create        | api        |
|        | DELETE    | api/images/{image}             | images.destroy     | App\Http\Controllers\Image\ImageController@destroy       | api        |
|        | PUT|PATCH | api/images/{image}             | images.update      | App\Http\Controllers\Image\ImageController@update        | api        |
|        | GET|HEAD  | api/images/{image}             | images.show        | App\Http\Controllers\Image\ImageController@show          | api        |
|        | GET|HEAD  | api/images/{image}/edit        | images.edit        | App\Http\Controllers\Image\ImageController@edit          | api        |
|        | GET|HEAD  | api/roles                      | roles.index        | App\Http\Controllers\Role\RoleController@index           | api        |
|        | POST      | api/roles                      | roles.store        | App\Http\Controllers\Role\RoleController@store           | api        |
|        | GET|HEAD  | api/roles/create               | roles.create       | App\Http\Controllers\Role\RoleController@create          | api        |
|        | PUT|PATCH | api/roles/{role}               | roles.update       | App\Http\Controllers\Role\RoleController@update          | api        |
|        | GET|HEAD  | api/roles/{role}               | roles.show         | App\Http\Controllers\Role\RoleController@show            | api        |
|        | DELETE    | api/roles/{role}               | roles.destroy      | App\Http\Controllers\Role\RoleController@destroy         | api        |
|        | GET|HEAD  | api/roles/{role}/edit          | roles.edit         | App\Http\Controllers\Role\RoleController@edit            | api        |
|        | POST      | api/users                      | users.store        | App\Http\Controllers\User\UserController@store           | api        |
|        | GET|HEAD  | api/users                      | users.index        | App\Http\Controllers\User\UserController@index           | api        |
|        | GET|HEAD  | api/users/create               | users.create       | App\Http\Controllers\User\UserController@create          | api        |
|        | PUT|PATCH | api/users/{user}               | users.update       | App\Http\Controllers\User\UserController@update          | api        |
|        | DELETE    | api/users/{user}               | users.destroy      | App\Http\Controllers\User\UserController@destroy         | api        |
|        | GET|HEAD  | api/users/{user}               | users.show         | App\Http\Controllers\User\UserController@show            | api        |
|        | GET|HEAD  | api/users/{user}/edit          | users.edit         | App\Http\Controllers\User\UserController@edit            | api        |
+--------+-----------+--------------------------------+--------------------+----------------------------------------------------------+------------+
 *
 */