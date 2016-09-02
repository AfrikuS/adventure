<?php

namespace App\Modules\Oil\Actions;

use App\Modules\Oil\Persistence\Repositories\EquipmentsRepo;

class InitiEquipment
{
    /** @var EquipmentsRepo */
    private $equipmentsRepo;
    
    public function createEquipments($hero_id)
    {
        $this->equipmentsRepo->createBy($hero_id);
    }
}
