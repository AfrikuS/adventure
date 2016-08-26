<?php

namespace App\Modules\Core\Providers;

use App\Modules\Core\Lib\IdentityMap;
use Illuminate\Support\ServiceProvider;

class CoreModuleProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEntityStore();
    }

    private function registerEntityStore()
    {
        $this->app->singleton('entityStore', function () {
            return IdentityMap::getInstance();
        });
    }
}
