<?php

namespace App\Modules\Drive\Domain\Entities\Garage;

interface RepairVehicle
{
    const STATUS_NORMAL = 'recovery';
    const STATUS_BROKEN = 'broken';

    public function repairOn($amount);

    public function recoveryAfterBreaking();

    public function refuel($amount);

    public function makeDamage(int $damage);
}
