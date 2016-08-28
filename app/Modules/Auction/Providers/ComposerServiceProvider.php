<?php

namespace App\Modules\Auction\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(
            '_partials.auction.things', 'App\Modules\Auction\View\Composers\ThingsComposer'
        );
    }

    public function register()
    {
    }
}
