<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\{
    Request,
    URL
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @throw Illuminate\Database\LazyLoadingViolationException 
         * Throw it in case the lazy loading of a model is presented
         */
        Model::preventLazyLoading(! $this->app->isProduction());

        /**
         * The global default validation settings for passwords
         */
        Password::defaults(function () {
            $rule = Password::min(10);
    
            return $this->app->isProduction()
                        ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                        : $rule;
        });

        if (
            (
                !empty(Request::server('REQUEST_SCHEME')) && 
                Request::server('REQUEST_SCHEME') === 'https'
            ) 
            ||
            (
                !empty(Request::server('HTTPS')) && 
                Request::server('HTTPS') != 'off' 
            )
            ||
            (
                Request::server('SERVER_PORT') === 443
            )
        ) {
            URL::forceScheme('https');
        }
    }
}
