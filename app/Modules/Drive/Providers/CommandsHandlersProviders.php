<?php

namespace App\Modules\Drive\Providers;

use App\Modules\Drive\Domain\Commands\Raid\DeleteRaid;
use App\Modules\Drive\Domain\Commands\Shop\CreateDetailOffer;
use App\Modules\Drive\Domain\Commands\Shop\DeleteDetailOffer;
use App\Modules\Drive\Domain\Commands\Shop\PurchaseDetail;
use App\Modules\Drive\Domain\Commands\Vehicle\MountDetail;
use App\Modules\Drive\Domain\Commands\Vehicle\UnmountDetail;
use App\Modules\Drive\Domain\Handlers\DeleteDetailOfferHandler;
use App\Modules\Drive\Domain\Handlers\Garage\MountDetailHandler;
use App\Modules\Drive\Domain\Handlers\Garage\UnmountDetailHandler;
use App\Modules\Drive\Domain\Handlers\Raid\DeleteRaidHandler;
use App\Modules\Drive\Domain\Handlers\Shop\CreateDetailOfferHandler;
use App\Modules\Drive\Domain\Handlers\Shop\PurchaseDetailHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandsHandlersProviders extends ServiceProvider
{
    protected $commandsHandlersMap = 
    [
        CreateDetailOffer::class   => CreateDetailOfferHandler::class,
        PurchaseDetail::class      => PurchaseDetailHandler::class,
        DeleteDetailOffer::class   => DeleteDetailOfferHandler::class,

        MountDetail::class         => MountDetailHandler::class,
        UnmountDetail::class       => UnmountDetailHandler::class,



        DeleteRaid::class          => DeleteRaidHandler::class,
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function boot()
    {
        $busMap = [];
        
        foreach ($this->commandsHandlersMap as $commandClass => $handlerClass) {
            
            $busMap[$commandClass] = $this->getHandlerMethod($handlerClass);
        }
        
        Bus::maps($busMap);
    }

    private function getHandlerMethod($classname)
    {
        return $classname . '@handle';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
