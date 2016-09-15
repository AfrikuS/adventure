<?php

namespace App\Modules\Geo\Providers;

use App\Modules\Geo\Persistence\Repositories\Business\ShipsRepo;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use App\Modules\Geo\Persistence\Repositories\Harbour\CruiseRepo;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoute\RoutePointsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use App\Modules\Geo\Persistence\Repositories\TravelsRepo;
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

        
        
        
        $this->app->singleton(
            'CruiseRepo', CruiseRepo::class
        );

        $this->app->singleton(
            'ShipsRepo', ShipsRepo::class
        );

    }

    private function registerDomainServices()
    {
    }
}
