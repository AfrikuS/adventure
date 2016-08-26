<?php

namespace App\Modules\Drive\Domain\Entities\Garage;

use Finite\Exception\StateException;

class RepairVehicle
{
    const STATUS_NORMAL = 'recovery';
    const STATUS_BROKEN = 'broken';

    public $id;
    public $status;
    public $damage_percent;
    public $fuel_level;
    
    public function __construct(\stdClass $vehicleData)
    {
        $this->id = $vehicleData->id;
        $this->status = $vehicleData->status;
        $this->damage_percent = $vehicleData->damage_percent;
        $this->fuel_level = $vehicleData->fuel_level;
    }

    public function repairOn($amount)
    {
        $summaryDamage = $this->damage_percent - $amount;

        if ($summaryDamage < 0) {
            $summaryDamage = 0;
        }

        $this->damage_percent = $summaryDamage;
    }

    public function recoveryAfterBreaking()
    {
        if ($this->status != self::STATUS_BROKEN) {

            throw new StateException;
        }
        
        $this->status = self::STATUS_NORMAL;
        $this->damage_percent = 80;
    }

    public function refuel($amount)
    {
        $this->fuel_level += $amount;
    }

    public function makeDamage(int $damage)
    {
        $summaryDamage = $this->damage_percent + $damage;

        if ($summaryDamage >= 100) {
            $summaryDamage = 100;

            $this->status = self::STATUS_BROKEN;
        }

        $this->damage_percent = $summaryDamage;
    }
}
