<?php

namespace App\Modules\Geo\Providers;

use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoute\RoutePointsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use App\Modules\Geo\Persistence\Repositories\TravelsRepo;
use App\Modules\Geo\Persistence\Repositories\VoyagesRepo;
use Illuminate\Support\ServiceProvider;

class GeoModuleProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'LocationsRepo', LocationsRepo::class
        );
        
        $this->app->singleton(
            'VoyagesRepo', VoyagesRepo::class
        );
        
        $this->app->singleton(
            'TravelRoutesRepo', TravelRoutesRepo::class
        );
        
        $this->app->singleton(
            'TravelsRepo', TravelsRepo::class
        );

        $this->app->singleton(
            'RoutePointsRepo', RoutePointsRepo::class
        );

    }

    private function registerDomainServices()
    {
    }
}
