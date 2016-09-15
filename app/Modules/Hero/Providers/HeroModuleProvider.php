<?php

namespace App\Modules\Hero\Providers;

use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Hero\Persistence\Repositories\ResourceChannelsRepo;
use Illuminate\Support\ServiceProvider;

class HeroModuleProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerDao();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'BuildingsRepo', BuildingsRepo::class
        );
        
        $this->app->singleton(
            'HeroRepo', HeroRepo::class
        );

        $this->app->singleton(
            'ResourceChannelsRepo', ResourceChannelsRepo::class
        );
    }

    private function registerDao()
    {
    }

    private function registerDomainServices()
    {
    }
}
