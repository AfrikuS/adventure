<?php

namespace App\Modules\Npc\Providers;

use App\Modules\Npc\Persistence\Repositories\CharactersRepo;
use App\Modules\Npc\Persistence\Repositories\DealsRepo;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Illuminate\Support\ServiceProvider;

class NpcModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();
        $this->registerDao();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'DealsRepo', DealsRepo::class
        );

        $this->app->singleton(
            'OffersRepo', OffersRepo::class
        );

        $this->app->singleton(
            'CharactersRepo', CharactersRepo::class
        );
    }

    private function registerDao()
    {
    }

    private function registerDomainServices()
    {
//        $this->app->singleton(
//            'OrderService', OrderService::class
//        );
//
    }
}
