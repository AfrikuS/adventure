<?php

namespace App\Modules\Employment\Providers;

use App\Handlers\Commands\AddEmploymentDomain;
use App\Handlers\Commands\AddEmploymentDomainHandler;
use App\Handlers\Commands\Employment\CreateLore;
use App\Handlers\Commands\Employment\CreateLoreHandler;
use App\Modules\Employment\Domain\Commands\Lore\LevelUpLoreSkill;
use App\Modules\Employment\Domain\Handlers\Lore\LevelUpLoreSkillHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandsHandlersProviders extends ServiceProvider
{
    protected $defer = false;
    
    protected $commandsHandlersMap = 
    [
        LevelUpLoreSkill::class => LevelUpLoreSkillHandler::class,
        
        AddEmploymentDomain::class => AddEmploymentDomainHandler::class,
        CreateLore::class          => CreateLoreHandler::class,
        LevelUpLoreSkill::class    => LevelUpLoreSkillHandler::class,
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
