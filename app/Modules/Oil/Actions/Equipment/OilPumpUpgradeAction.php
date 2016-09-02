<?php

namespace App\Modules\Oil\Actions\Equipment;

use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Domain\Services\Base\EquipmentService;
use App\Modules\Oil\Persistence\Repositories\OilPumpRepo;
use Finite\Exception\StateException;

class OilPumpUpgradeAction
{
    /** @var  OilPumpRepo */
    private $oilPumpRepo;

    public function __construct()
    {
        $this->oilPumpRepo = app('OilPumpRepo');
    }

    public function upgrade($hero_id)
    {
        /** @var OilPump $oilPump */
        $oilPump = $this->oilPumpRepo->findBy($hero_id);
        
        $this->validateAction($oilPump);

        
        $equipmentService = new EquipmentService();

        $equipmentService->upgradeOilPump($hero_id);
        
    }

    private function validateAction(OilPump $oilPump)
    {
        if ($oilPump->isFullUpgrade()) {
            
            throw new StateException('Нефтяной насос прокачан по максимуму');
        }
    }
}
