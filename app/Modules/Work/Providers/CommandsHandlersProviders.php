<?php

namespace App\Modules\Work\Providers;

use App\Modules\Work\Domain\Commands\Order\AcceptOrder;
use App\Modules\Work\Domain\Commands\Order\Builder\CreateOrderData;
use App\Modules\Work\Domain\Commands\Order\Builder\GenerateMaterials;
use App\Modules\Work\Domain\Commands\Order\Builder\GenerateSkills;
use App\Modules\Work\Domain\Commands\Order\DeleteOrder;
use App\Modules\Work\Domain\Commands\Order\Status\OrderAccepted;
use App\Modules\Work\Domain\Commands\Order\Status\OrderCompleted;
use App\Modules\Work\Domain\Commands\Order\Status\OrderEstimated;
use App\Modules\Work\Domain\Commands\Order\Status\OrderStockedMaterials;
use App\Modules\Work\Domain\Commands\Order\StockMaterial;
use App\Modules\Work\Domain\Commands\Order\StockSkill;
use App\Modules\Work\Domain\Commands\Worker\AddInstrument;
use App\Modules\Work\Domain\Commands\Worker\AddMaterial;
use App\Modules\Work\Domain\Commands\Worker\DecrementMaterial;
use App\Modules\Work\Domain\Handlers\Order\AcceptOrderHandler;
use App\Modules\Work\Domain\Handlers\Order\Builder\CreateOrderDataHandler;
use App\Modules\Work\Domain\Handlers\Order\Builder\GenerateMaterialsHandler;
use App\Modules\Work\Domain\Handlers\Order\Builder\GenerateSkillsHandler;
use App\Modules\Work\Domain\Handlers\Order\DeleteOrderHandler;
use App\Modules\Work\Domain\Handlers\Order\Status\OrderAcceptedHandler;
use App\Modules\Work\Domain\Handlers\Order\Status\OrderCompletedHandler;
use App\Modules\Work\Domain\Handlers\Order\Status\OrderEstimatedHandler;
use App\Modules\Work\Domain\Handlers\Order\Status\OrderStockedMaterialsHandler;
use App\Modules\Work\Domain\Handlers\Order\StockMaterialHandler;
use App\Modules\Work\Domain\Handlers\Order\StockSkillHandler;
use App\Modules\Work\Domain\Handlers\Worker\AddInstrumentHandler;
use App\Modules\Work\Domain\Handlers\Worker\AddMaterialHandler;
use App\Modules\Work\Domain\Handlers\Worker\DecrementMaterialHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandsHandlersProviders extends ServiceProvider
{
    protected $defer = false;
    
    protected $commandsHandlersMap = 
    [
        AddMaterial::class => AddMaterialHandler::class,
        DecrementMaterial::class => DecrementMaterialHandler::class,
        AddInstrument::class => AddInstrumentHandler::class,

        
        // order commands
        CreateOrderData::class => CreateOrderDataHandler::class, 
        
        GenerateMaterials::class => GenerateMaterialsHandler::class, 
        GenerateSkills::class => GenerateSkillsHandler::class, 
        
        AcceptOrder::class => AcceptOrderHandler::class,
        OrderAccepted::class => OrderAcceptedHandler::class,

        OrderEstimated::class => OrderEstimatedHandler::class,

        StockMaterial::class => StockMaterialHandler::class,
        OrderStockedMaterials::class=> OrderStockedMaterialsHandler::class,

        StockSkill::class => StockSkillHandler::class,

        OrderCompleted::class => OrderCompletedHandler::class,

        
        DeleteOrder::class => DeleteOrderHandler::class,
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
            
            $busMap[$commandClass] = $handlerClass.'@'.'handle';
        }
        
        Bus::maps($busMap);
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
