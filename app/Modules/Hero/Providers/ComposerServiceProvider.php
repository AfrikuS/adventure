<?php

namespace App\Modules\Hero\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(
            '_partials.hero.resources', 'App\Modules\Hero\View\Composers\ResourcesComposer'
        );
    }

    public function register()
    {
    }
}
