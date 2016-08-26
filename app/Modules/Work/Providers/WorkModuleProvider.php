<?php

namespace App\Modules\Work\Providers;

use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Domain\Services\Order\WorkerOrderService;
use App\Modules\Work\Domain\Services\Shop\ShopService;
use App\Modules\Work\Persistence\Dao\Order\OrderDao;
use App\Modules\Work\Persistence\Dao\Order\OrderMaterialsDao;
use App\Modules\Work\Persistence\Dao\Shop\ShopInstrumentsDao;
use App\Modules\Work\Persistence\Dao\Shop\ShopMaterialsDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerInstrumentsDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerMaterialsDao;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;
use App\Modules\Work\Persistence\Repositories\Team\TeamRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerInstrumentsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerSkillsRepo;
use Illuminate\Support\ServiceProvider;

class WorkModuleProvider extends ServiceProvider
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
            'CatalogMaterialsRepo', MaterialsRepo::class
        );
        $this->app->singleton(
            'OrderRepo', OrderRepo::class
        );

/*        $this->app->singleton(
            'WorkShopRepo', ShopRepo::class
        );*/


        $this->app->singleton(
            'WorkerRepo', WorkerRepo::class
        );

        $this->app->singleton(
            'OrderRepo', OrderRepo::class
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

        
        

    }

    private function registerDao()
    {
        $this->app->singleton(
            'OrderDao', OrderDao::class
        );
        $this->app->singleton(
            'OrderMaterialsDao', OrderMaterialsDao::class
        );

        $this->app->singleton(
            'WorkerDao', WorkerDao::class
        );
        $this->app->singleton(
            'WorkerMaterialsDao', WorkerMaterialsDao::class
        );
        $this->app->singleton(
            'WorkerInstrumentsDao', WorkerInstrumentsDao::class
        );

        $this->app->singleton(
            'ShopMaterialsDao', ShopMaterialsDao::class
        );
        $this->app->singleton(
            'ShopInstrumentsDao', ShopInstrumentsDao::class
        );
    }

    private function registerDomainServices()
    {
        $this->app->singleton(
            'OrderService', OrderService::class
        );

        $this->app->singleton(
            'WorkerOrderService', WorkerOrderService::class
        );

        $this->app->singleton(
            'WorkShopService', ShopService::class
        );

    }
}
