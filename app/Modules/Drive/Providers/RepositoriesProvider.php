<?php

namespace App\Modules\Drive\Providers;

use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Dao\DriversDao;
use App\Modules\Drive\Persistence\Dao\Raid\RaidsDao;
use App\Modules\Drive\Persistence\Dao\VehiclesDao;
use App\Modules\Drive\Persistence\Repositories\CatalogsRepo;
use App\Modules\Drive\Persistence\Repositories\DriversRepo;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use App\Modules\Drive\Persistence\Repositories\ShopRepo;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Задаём, отложена ли загрузка провайдера.
     *
     * @var bool
     */
//    protected $defer = true;

//    protected $defer = true;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerRaidRepositories();

        $this->registerDomainServices();
    }

    protected function registerRepositories()
    {
        $this->app->singleton(
            'DriveCatalogsRepo', CatalogsRepo::class
        );

        $this->app->singleton(
            'DriveShopRepo', ShopRepo::class
        );

        $this->app->singleton(
            'DriveDetailsRepo', DetailsRepo::class
        );
        $this->app->singleton(
            'DriveDriversRepo', DriversRepo::class
        );


        $this->app->singleton(
            'DriveDriversDao', DriversDao::class
        );
        $this->app->singleton(
            'DriveVehiclesRepo', VehiclesRepo::class
        );
            $this->app->singleton(
                'DriveVehiclesDao', VehiclesDao::class
            );

//        $this->app->singleton(
//            'DriveVehiclesRepo', VehiclesRepo::class
//        );

    }


    private function registerDomainServices()
    {
        $this->app->singleton(
            'RobberyService', RobberyService::class
        );
    }

//    protected function boot()
//    {
//        $this->app->singleton('DomainsCatalog', function () {
//            return app('DomainRepo')->getCatalog();
//        });
//    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['DriveCatalogsRepo', 'DriveShopRepo'];
    }

    private function registerRaidRepositories()
    {
        $this->app->singleton(
            'DriveRaidRepo', RaidsRepo::class
        );
        $this->app->singleton(
            'DriveRaidsDao', RaidsDao::class
        );
        $this->app->singleton(
            'DriveRobberyRepo', RobberyRepo::class
        );
    }

}
