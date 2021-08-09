<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\Gate;
use App\Models\User;
=======
use Illuminate\Support\Facades\{
    Gate,
    Request
};
>>>>>>> 2c04c23 (Init commit)

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

<<<<<<< HEAD
        Gate::define('full-granted', function(User $user) {
            return;
        });
=======
        Gate::define('full-granted', 'App\Policies\CommonPolicy@fullGranted');

        Gate::define('api-mobile-granted', 'App\Policies\CommonPolicy@apiMobileGranted');
>>>>>>> 2c04c23 (Init commit)
    }
}
