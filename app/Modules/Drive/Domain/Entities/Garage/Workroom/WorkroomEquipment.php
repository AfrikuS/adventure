<?php

namespace App\Modules\Drive\Domain\Entities\Workroom;

class WorkroomEquipment
{
    public $id;
    public $refuelerLevel;
    public $liftLevel;
    public $restorerLevel; // recover

    public function __construct(\stdClass $equipmentData)
    {
        $this->id = $equipmentData->id;
        $this->refuelerLevel = $equipmentData->refuelerLevel;
        $this->liftLevel = $equipmentData->liftLevel;
        $this->restorerLevel = $equipmentData->restorerLevel;
    }
}
