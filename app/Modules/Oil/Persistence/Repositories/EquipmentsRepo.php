<?php

namespace App\Modules\Oil\Persistence\Repositories;

use App\Modules\Oil\Persistence\Dao\EquipmentsDao;

class EquipmentsRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }

    public function createBy($hero_id)
    {
        $this->equipmentsDao->create($hero_id, 0, 0);
    }

    public function findBy($hero_id)
    {
        return $this->equipmentsDao->find($hero_id);
    }
}
