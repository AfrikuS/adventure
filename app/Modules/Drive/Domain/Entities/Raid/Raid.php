<?php

namespace App\Modules\Drive\Domain\Entities\Raid;

class Raid
{
    const RAID_STATUS_SEARCH_VICTIM = 'search_victim';
    const RAID_STATUS_ON_REPAIR = 'repair';
    const RAID_STATUS_IN_ROBBERY = 'in_robbery';
    const RAID_STATUS_FREE = 'switch_action';

    public $id;
    public $vehicle_id;
    public $victim_id;
    public $status;
    public $reward;

    public function __construct(\stdClass $raidData)
    {
        $this->id = $raidData->id;
        $this->vehicle_id = $raidData->vehicle_id;
        $this->victim_id = $raidData->victim_id;
        $this->status = $raidData->status;
        $this->reward = $raidData->reward;
    }

    public function fondVictim($victim_id)
    {
        $this->status = self::RAID_STATUS_SEARCH_VICTIM;

        $this->victim_id = $victim_id;
    }

    public function setStatusInRobbery()
    {
        $this->status = self::RAID_STATUS_IN_ROBBERY;
    }

    public function setStatusFree()
    {
        $this->status = self::RAID_STATUS_FREE;
    }

}
