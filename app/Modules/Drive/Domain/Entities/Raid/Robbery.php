<?php

namespace App\Modules\Drive\Domain\Entities\Raid;

use App\Modules\Drive\Domain\Services\Raid\RobberyService;

class Robbery
{
    public $id;
    public $status;
    public $robbery_status;
    public $victim_id;
    public $vehicle_id;

    public function __construct(\stdClass $robberyData)
    {
        $this->id = $robberyData->id;
        $this->status = $robberyData->status;
        $this->robbery_status = $robberyData->robbery_status;
        $this->victim_id = $robberyData->victim_id;
        $this->vehicle_id = $robberyData->vehicle_id;
    }

    public function complete()
    {
        $this->status = RobberyService::RAID_STATUS_SWITCH;
    }

    public function driveInFence()
    {
        $this->robbery_status = RobberyService::ROBBERY_STATUS_COURTYARD;
    }

    public function driveInAmbar()
    {
        $this->robbery_status = RobberyService::ROBBERY_STATUS_AMBAR;
    }

    public function driveInWarehouse()
    {
        $this->robbery_status = RobberyService::ROBBERY_STATUS_WAREHOUSE;
    }

    public function driveInHouse()
    {
        $this->robbery_status = RobberyService::ROBBERY_STATUS_HOUSE;
    }

    public function driveInGates()
    {
        $this->robbery_status = RobberyService::ROBBERY_STATUS_FENCE;
    }

}
