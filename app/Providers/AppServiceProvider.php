<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // because of 'charset' => 'utf8mb4' which is set in

        User::created(function($user) {
            Mail::to($user->email)->send(new UserCreated($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
