<?php

namespace App\Factories\Hero;

use App\Models\Core\Equipment;

class HeroEquipmentFactory
{

    public function createEquipment($hero_id)
    {
        return Equipment::create([

            'hero_id' => $hero_id,

            'pump_level' => 0,
            'oil_distillator_level' => 0,

        ]);
    }
}
