<?php

namespace App\Modules\Oil\Providers;

use App\Modules\Oil\Persistence\Repositories\EquipmentsRepo;
use App\Modules\Oil\Persistence\Repositories\ResourceStoresRepo;
use Illuminate\Support\ServiceProvider;

class OilModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'ResourceStoresRepo', ResourceStoresRepo::class
        );

        $this->app->singleton(
            'EquipmentsRepo', EquipmentsRepo::class
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
