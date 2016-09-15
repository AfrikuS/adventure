<?php

namespace App\Modules\Hero\Domain\Entities;

class Buildings
{
    const GATES = 'gates';
    const FENCE = 'fence';
    const AMBAR_DOOR = 'ambar';
    const HAUSE_DOOR = 'hause';
    
    public $id;
    public $gatesLevel;
    public $fenceLevel;
    public $ambarLevel;
    public $houseLevel;
    public $warehauseLevel;

    public function __construct(\stdClass $buildingsData)
    {
        $this->id = $buildingsData->id;
        $this->gatesLevel = $buildingsData->gates_level;
        $this->fenceLevel = $buildingsData->fence_level;
        $this->houseLevel = $buildingsData->door_house_level;
        $this->ambarLevel = $buildingsData->door_ambar_level;
        $this->warehauseLevel = $buildingsData->door_resource_warehause_level;
    }

    public function makeFenceDamage(int $damage)
    {
        
    }
}
