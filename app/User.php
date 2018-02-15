<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; // trait for soft deleting

    const VERIFIED_USER = '1'; // keep as string no number
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'verified',
        'verification_token',
        'town',
        'country',
        'admin' // zrob najpier tak a pozniej dodasz role i zmienisz
    ];

    /**
     * The attributes that should be hidden for arrays when returned by laravel in response
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    // check if user is Verified
    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    // check if user is Admin
    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    // create static method for generating verification code
    // static to have easy way to obtain (generate) verification code directly from the model
    public static function generateVerificationCode()
    {
        return str_random(40);
    }


    // user can have many articles
    public function articles() {

        return $this->hasMany('App\Article');
    }

    // user can have many comment
    public function comments() {

        return $this->hasMany('App\Comment');
    }
}
