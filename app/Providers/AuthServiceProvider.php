<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // for passport routes add this
        // Passport::routes(); // when there is no prefix
        Passport::routes(null, ['prefix' => 'api/oauth']); // when you keep api prefix
        Passport::tokensExpireIn(Carbon::now()->addSeconds(360));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
