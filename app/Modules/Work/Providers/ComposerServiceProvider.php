<?php

namespace App\Modules\Work\Providers;

use App\Modules\Work\View\Composers\TeamComposer;
use App\Modules\Work\View\Composers\WorkerComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        \View::composers([
//            WorkerComposer::class => ['work.work_layout'],
//            TeamComposer::class => 'work.team.show.layout',
//        ]);
        // Использование построителей на основе класса...
        view()->composer('work.work_layout', 'App\Modules\Work\View\Composers\WorkerComposer');
//
        view()->composer('work.team.show.layout', 'App\Modules\Work\View\Composers\TeamComposer');
    }

    public function register()
    {
    }
}
