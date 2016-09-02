<?php

namespace App\Modules\Employment\Providers;

use App\Modules\Employment\Persistence\Repositories\DomainsRepo;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use App\Modules\Employment\View\Repositories\SchoolRepo;
use Illuminate\Support\ServiceProvider;

class EmploymentModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'DomainsRepo', DomainsRepo::class
        );
        
        $this->app->singleton(
            'LoreRepo', LoreRepo::class
        );

        
        
        
        
        $this->app->singleton(
            'SchoolRepo', SchoolRepo::class
        );

//        $this->app->singleton('DomainsCatalog', function () {
//            return app('DomainsRepo')->getCatalog();
//        });

    }


    private function registerDomainServices()
    {
    }
}
