<?php

namespace App\Modules\Drive\Domain\Entities\Raid;

class Robbery
{
    const STATUS_GATES = 'gates';
    const STATUS_FENCE = 'fence';
    const STATUS_HOUSE = 'house';
    const ROBBERY_STATUS_AMBAR = 'ambar';
    const ROBBERY_STATUS_WAREHOUSE = 'warehouse';
    const STATUS_COURTYARD = 'courtyard';
    const NO_ACTIVE = 'no_active';

    public $id;
    public $status;
    public $victim_id;
    public $vehicle_id;

    public function __construct(\stdClass $robberyData)
    {
        $this->id = $robberyData->raid_id;
        $this->status = $robberyData->status;
        $this->victim_id = $robberyData->victim_id;
        $this->vehicle_id = $robberyData->vehicle_id;
    }

    public function fondVictim($victim_id)
    {
        $this->victim_id = $victim_id;
    }
    
    public function driveInFence()
    {
        $this->status = self::STATUS_COURTYARD;
    }

    public function driveInAmbar()
    {
        $this->status = self::ROBBERY_STATUS_AMBAR;
    }

    public function driveInWarehouse()
    {
        $this->status = self::ROBBERY_STATUS_WAREHOUSE;
    }

    public function driveInHouse()
    {
        $this->status = self::STATUS_HOUSE;
    }

    public function driveInGates()
    {
        $this->status = self::STATUS_FENCE;
    }

    public function abort()
    {
        $this->status = self::NO_ACTIVE;
        $this->victim_id = null;
    }
}
