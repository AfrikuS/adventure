<?php

namespace App\Modules\Auction\Providers;

use App\Modules\Auction\Persistence\Repositories\AuctionRepo;
use App\Modules\Auction\Persistence\Repositories\ThingsRepo;
use Illuminate\Support\ServiceProvider;

class AuctionModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRepositories();

        $this->registerDomainServices();
    }

    private function registerRepositories()
    {
        $this->app->singleton(
            'AuctionRepo', AuctionRepo::class
        );
        
        $this->app->singleton(
            'ThingsRepo', ThingsRepo::class
        );
        
    }

    private function registerDomainServices()
    {
    }
}
