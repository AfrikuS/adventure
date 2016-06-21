<?php

namespace App\Providers;

use App\Domain\Game\Fight;
use Illuminate\Support\ServiceProvider;

class FightServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Domain\Game\Fight', function($app)
        {
            return new Fight();
        });


    }
}
