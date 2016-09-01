<?php

namespace App\Modules\Oil\Actions;

class InitiEquipment
{
    public function createEquipments()
    {
        Equipment::create([

            'hero_id' => $hero_id,

            'pump_level' => 0,
            'oil_distillator_level' => 0,

        ]);
    }
}
