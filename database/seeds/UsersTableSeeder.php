<?php

use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{

    public function run()
    {
        // - clear truncate whole DB for the project through model class
        User::truncate();
        // the same but with DB
        //DB::table('users')->delete();

        // how many users
//        $usersQuantity = 10;
//        // use factory to create inserts
//        factory(User::class, $usersQuantity)->create(); // create() is to store data in db


        $faker = Faker\Factory::create();
        foreach (range(1, 10) as $index) {

            $user = new User();
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->created_at = $faker->dateTime();
            $user->updated_at = $faker->dateTime();
            $user->password = bcrypt('secret');
            $user->save();

//            DB::table('users')->insert([
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'created_at' => $faker->dateTime(),
//                'updated_at' => $faker->dateTime(),
//                'password' => bcrypt('secret')
//            ]);
        }
    }
}