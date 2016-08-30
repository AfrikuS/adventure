<?php

namespace App\Modules\Drive\Providers;

use App\Modules\Drive\View\Composers\VehicleComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(
            '_partials.drive.vehicle', VehicleComposer::class
        );
    }

    public function register()
    {
    }
}
