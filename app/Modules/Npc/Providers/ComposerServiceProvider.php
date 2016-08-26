<?php

namespace App\Modules\Npc\Providers;

use App\Modules\Npc\View\Composers\DealsComposer;
use App\Modules\Npc\View\Composers\OffersComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('layouts.app', OffersComposer::class);
        view()->composer('layouts.app', DealsComposer::class);
    }

    public function register()
    {
    }
}
