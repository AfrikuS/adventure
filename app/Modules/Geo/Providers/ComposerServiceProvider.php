<?php

namespace App\Modules\Geo\Providers;

use App\Modules\Geo\View\Composers\MapComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(
            '_partials.geo.map', MapComposer::class
        );
    }

    public function register()
    {
    }
}
