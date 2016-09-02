<?php

namespace App\Modules\Work\Providers;

use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Domain\Services\Order\WorkerOrderService;
use App\Modules\Work\Domain\Services\Shop\ShopService;
use App\Modules\Work\Persistence\Dao\Order\OrdersDao;
use App\Modules\Work\Persistence\Dao\Order\OrderMaterialsDao;
use App\Modules\Work\Persistence\Dao\Shop\ShopInstrumentsDao;
use App\Modules\Work\Persistence\Dao\Shop\ShopMaterialsDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerInstrumentsDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerMaterialsDao;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;
use App\Modules\Work\Persistence\Repositories\Team\TeamRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerInstrumentsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerSkillsRepo;
use App\Modules\Work\View\Repositories\OrdersItemsRepo;
use Illuminate\Support\ServiceProvider;

class WorkModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'CatalogMaterialsRepo', MaterialsRepo::class
        );
        $this->app->singleton(
            'OrdersRepo', OrdersRepo::class
        );

        $this->app->singleton(
            'WorkerRepo', WorkerRepo::class
        );

        $this->app->singleton(
            'WorkerMaterialsRepo', WorkerMaterialsRepo::class
        );

        $this->app->singleton(
            'OrderMaterialsRepo', OrderMaterialsRepo::class
        );

        $this->app->singleton(
            'OrderSkillsRepo', OrderSkillsRepo::class
        );

        $this->app->singleton(
            'WorkerInstrumentsRepo', WorkerInstrumentsRepo::class
        );

        $this->app->singleton(
            'WorkerSkillsRepo', WorkerSkillsRepo::class
        );


        $this->app->singleton(
            'WorkShopRepo', ShopRepo::class
        );

        $this->app->singleton(
            'ShopMaterialsRepo', ShopMaterialsRepo::class
        );


        $this->app->singleton(
            'TeamRepo', TeamRepo::class
        );

        
        
        
        $this->app->singleton(
            'OrdersItemsRepo', OrdersItemsRepo::class
        );
    }

    private function registerDomainServices()
    {
        $this->app->singleton(
            'OrderService', OrderService::class
        );

        $this->app->singleton(
            'WorkShopService', ShopService::class
        );
    }
}
