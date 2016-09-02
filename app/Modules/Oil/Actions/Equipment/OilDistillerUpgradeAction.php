<?php

namespace App\Modules\Oil\Actions\Equipment;


use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Domain\Services\Base\EquipmentService;
use App\Modules\Oil\Persistence\Repositories\OilDistillerRepo;
use Finite\Exception\StateException;

class OilDistillerUpgradeAction
{
    const MAX_OIL_DISTILLER_LEVEL    = 5;

    /** @var  OilDistillerRepo */
    private $distillerRepo;

    public function __construct()
    {
        $this->distillerRepo = app('OilDistillerRepo');
    }

    public function upgrade($hero_id)
    {
        /** @var OilDistiller $distiller */
        $distiller = $this->distillerRepo->findBy($hero_id);

        $this->validateAction($distiller);


        $equipmentService = new EquipmentService();

        $equipmentService->upgradeOilDistiller($distiller);

    }

    private function validateAction(OilDistiller $distiller)
    {
        if ($distiller->isFullUpgrade()) {

            throw new StateException('Перегонный аппарат прокачан по максимуму');
        }
    }
}
