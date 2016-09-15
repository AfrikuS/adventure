<?php

namespace App\Modules\Drive\Persistence\Repositories\Workroom;

use App\Models\Core\Equipment;
use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Persistence\Dao\EquipmentsDao;

class RestorerRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }
    
    public function findBy($hero_id)
    {
        $oilPumpData = $this->equipmentsDao->findOilPumpBy($hero_id);
        
        $oilPump = new OilPump($oilPumpData);
        
        return $oilPump;
    }

    public function updateLevel(OilPump $oilPump)
    {
        $this->equipmentsDao->updatePump(
            $oilPump->hero_id,
            $oilPump->level
        );
    }

/*    public function getPumpOilDto($hero_id)
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
    }*/

    public function findOilDistillatorByHeroId($hero_id)
    {
        $model = Equipment::
            select('hero_id', 'oil_distillator_level')
            ->find($hero_id);

        return $model;

    }

//    public function getOilDistillatorDto($hero_id)
//    {
//        $pumpOilModel = $this->findOilDistillatorByHeroId($hero_id);
//
//        $pumpOilDto = new OilDistillatorDto
//        (
//            $pumpOilModel->oil_distillator_level
//        );
//
//        return $pumpOilDto;
//    }
}
