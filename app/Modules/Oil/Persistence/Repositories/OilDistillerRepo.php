<?php

namespace App\Modules\Oil\Persistence\Repositories;

use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Persistence\Dao\EquipmentsDao;

class OilDistillerRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }

    public function findBy($hero_id)
    {
        $oilDistillerData = $this->equipmentsDao->findOilDistillerBy($hero_id);

        $oilDistiller = new OilDistiller($oilDistillerData);

        return $oilDistiller;
    }

    public function updateLevel(OilDistiller $oilDistiller)
    {
        $this->equipmentsDao->updateDistiller(
            $oilDistiller->hero_id,
            $oilDistiller->level
        );
    }
}
