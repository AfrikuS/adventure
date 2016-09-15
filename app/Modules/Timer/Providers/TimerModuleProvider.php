<?php

namespace App\Modules\Timer\Providers;

use App\Modules\Timer\Persistence\Repositories\TimersRepo;
use Illuminate\Support\ServiceProvider;

class TimerModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'TimersRepo', TimersRepo::class
        );

    }

    private function registerDomainServices()
    {
//        $this->app->singleton(
//            'OrderService', OrderService::class
//        );
//
    }
}
