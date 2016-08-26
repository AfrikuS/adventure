<?php

namespace App\Modules\Work\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Использование построителей на основе класса...
        view()->composer('work.work_layout', 'App\Modules\Work\View\Composers\WorkerComposer');

        view()->composer('work.team.show.layout', 'App\Modules\Work\View\Composers\TeamComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
