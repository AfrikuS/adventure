<?php

namespace App\Modules\Battle\Providers;

use App\Modules\Battle\Persistence\Repository\AttacksRepo;
use Illuminate\Support\ServiceProvider;

class BattleModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerRepositories();
    }

    private function registerRepositories()
    {
        $this->app->singleton('AttacksRepo', AttacksRepo::class);
    }
}
