<?php

use App\User;
use App\Category;
use App\Article;
use App\Image;
use App\Comment;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

// User
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        //'avatar' => $faker->image('storage/app/public/images/avatar',400,400, 'people', false),
        'avatar' => $faker->image('public/images/avatar',400,400, 'people', false),
        'city' => $faker->city(),
        'country' => $faker->country(),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]), // 0 or 1
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER]), // true or false
    ];
});

// Category - you need only name and one paragraph of description
$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1), // 1 paragraph
        'parent_id' => 0,
    ];
});


// Article
$factory->define(Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->paragraph(1),
        'card_text' => $faker->paragraph(2),
        'text' => $faker->paragraph(50),
        'tags' => $faker->word(1),
        'public' => $faker->randomElement([0, 1]),
        'category_id' => Category::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});

// Image
$factory->define(Image::class, function (Faker\Generator $faker) {
    return [
        //'image' => $faker->image('storage/app/public/images/article',400,400, 'technics', false),
        'image' => $faker->image('public/images/article',400,400, 'technics', false),
        'caption' => $faker->paragraph(1),
        'type' => $faker->randomElement(['hero', 'card', 'in-text']),
        'article_id' => Article::all()->random()->id,
    ];
});


// Comment
$factory->define(Comment::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->paragraph(2),
        'public' => $faker->randomElement([0, 1]),
        'user_id' => User::all()->random()->id,
        'article_id' => Article::all()->random()->id,
    ];
});
