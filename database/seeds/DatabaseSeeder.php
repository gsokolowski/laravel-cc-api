<?php

use App\User;
use App\Category;
use App\Article;
use App\Image;
use App\Comment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // Seed Database through factories files


        // To be able to run and seed DB wih data
        // you need to have setup in database/factories/ModelFactory.php
        // then:

        // - disable database FOREIGN_KEY_CHECKS
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // - clear truncate whole DB for the project through model class
        User::truncate();
        $this->removeImages('app/public/images/avatar/*.jpg');

        Category::truncate();

        Article::truncate();
        $this->removeImages('app/public/images/article/*.jpg');

        Image::truncate();
        Comment::truncate();

        $usersQuantity = 3;
        $categoriesQuantity = 5;
        $articlesQuantity = 10;
        $imagesQuantity = 30;
        $commentsQuantity = 30;

        // use factory to create inserts
        factory(User::class, $usersQuantity)->create(); // create() is to store data in db
        $this->command->info('User table seeded!');

        factory(Category::class, $categoriesQuantity)->create();
        $this->command->info('Category table seeded!');

        factory(Article::class, $articlesQuantity)->create();
        $this->command->info('Article table seeded!');

        factory(Image::class, $imagesQuantity)->create();
        $this->command->info('Image table seeded!');

        factory(Comment::class, $commentsQuantity)->create();
        $this->command->info('Comment table seeded!');


        // Seed Database through seeder files
        // $this->call(UsersTableSeeder::class);
        // $this->command->info('User table seeded!');
    }

    private function removeImages($path) {

        //dd(storage_path($path));
        $files = glob(storage_path($path)); // get all file names
        //dd($files);

        foreach($files as $file) { // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }
}
