<?php

namespace App\Modules\Geo\Providers;

use App\Modules\Hero\Domain\Commands\Resources\DecrementGold;
use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use App\Modules\Hero\Domain\Handlers\Resources\DecrementGoldHandler;
use App\Modules\Hero\Domain\Handlers\Resources\IncrementGoldHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandsHandlersProviders extends ServiceProvider
{
    protected $defer = false;
    
    protected $commandsHandlersMap = 
    [
//        DecrementGold::class => DecrementGoldHandler::class,
//        IncrementGold::class => IncrementGoldHandler::class,
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
