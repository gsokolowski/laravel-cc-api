<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
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

        // We are going to register a created event for a User model when user is created for the first time
        User::created(function($user) {
            // Retry 5 times doing that is in function() and try every 100 milisecond
            retry(5, function() use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));
            },100);
        });

        // We are going to register a created event for a User model if user is updating  email
        User::updated(function($user) {
            // if email field is changed then send email using UserMailChanged
            if($user->isDirty('email')) {
                // Retry 5 times doing that is in function() and try every 100 milisecond
                retry(5, function() use ($user) {
                    Mail::to($user->email)->send(new UserMailChanged($user));
                },100);
            }
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
