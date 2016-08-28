<?php

namespace App\Modules\Auction\Providers;

use App\Modules\Auction\Domain\Commands\PurchaseThing;
use App\Modules\Auction\Domain\Handlers\PurchaseThingHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandsHandlersProviders extends ServiceProvider
{
    protected $defer = false;
    
    protected $commandsHandlersMap = 
    [
        PurchaseThing::class => PurchaseThingHandler::class,
    ];
    
    public function boot()
    {
        $busMap = [];
        
        foreach ($this->commandsHandlersMap as $commandClass => $handlerClass) {
            
            $busMap[$commandClass] = $handlerClass.'@'.'handle';
        }
        
        Bus::maps($busMap);
    }

    public function register()
    {
        
    }
}
