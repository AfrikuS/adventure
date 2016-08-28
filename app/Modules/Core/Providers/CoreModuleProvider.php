<?php

namespace App\Modules\Core\Providers;

use App\Modules\Core\Lib\IdentityMap;
use App\Modules\Core\Persistence\Repositories\UsersRepo;
use Illuminate\Support\ServiceProvider;

class CoreModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerEntityStore();
        
        $this->registerRepositories();
    }

    private function registerEntityStore()
    {
        $this->app->singleton('entityStore', function () {
            return IdentityMap::getInstance();
        });
    }

    private function registerRepositories()
    {
        $this->app->singleton('UsersRepo', UsersRepo::class);
    }
}
