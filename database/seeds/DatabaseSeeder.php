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
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
        $this->removeImages('storage/images/user/*');

        Category::truncate();

        Article::truncate();
        $this->removeImages('storage/images/article/*');

        Image::truncate();
        Comment::truncate();

        $usersQuantity = 2;
        $categoriesQuantity = 5;
        $articlesQuantity = 10;
        $imagesQuantity = 30;
        $commentsQuantity = 30;

        // use factory to create inserts
        factory(User::class, $usersQuantity)->create(); // create() is to store data in db
        factory(Category::class, $categoriesQuantity)->create();
        factory(Article::class, $articlesQuantity)->create();

        factory(Image::class, $imagesQuantity)->create();
        factory(Comment::class, $commentsQuantity)->create();


        // Seed Database through seeder files
        // $this->call(UsersTableSeeder::class);
        // $this->command->info('User table seeded!');
    }

    private function removeImages($path) {

        $files = glob($path); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }
}
