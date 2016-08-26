<?php

namespace App\Repositories\Core\Equipment;

use App\Factories\Hero\HeroEquipmentFactory;
use App\Models\Core\Equipment;
use App\ViewData\Hero\Equipment\OilDistillatorDto;
use App\ViewData\Hero\Equipment\PumpOilDto;

class PumpOilRepo
{
    public function findPumpOilByHeroId($hero_id)
    {
        $model = Equipment::
                select('hero_id', 'pump_level')
                ->find($hero_id);

        return $model;
    }

    public function getPumpOilDto($hero_id)
    {
        $pumpOilModel = $this->findPumpOilByHeroId($hero_id);

        if (null == $pumpOilModel) {
            $factory = new HeroEquipmentFactory();
            $pumpOilModel = $factory->createEquipment($hero_id); 
        }
        
        $pumpOilDto = new PumpOilDto
        (
            $pumpOilModel->pump_level
        );

        return $pumpOilDto;
    }

    public function findOilDistillatorByHeroId($hero_id)
    {
        $model = Equipment::
            select('hero_id', 'oil_distillator_level')
            ->find($hero_id);

        return $model;

    }

    public function getOilDistillatorDto($hero_id)
    {
        $pumpOilModel = $this->findOilDistillatorByHeroId($hero_id);

        $pumpOilDto = new OilDistillatorDto
        (
            $pumpOilModel->oil_distillator_level
        );

        return $pumpOilDto;
    }
}
