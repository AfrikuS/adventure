<?php

namespace App\Modules\Drive\Persistence\Repositories\Workroom;

use App\Modules\Drive\Persistence\Dao\Workroom\EquipmentsDao;

class EquipmentsRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }

    public function createBy($driver_id)
    {
        $this->equipmentsDao->create($driver_id, 0, 0, 0);
    }

    public function findBy($driver_id)
    {
        return $this->equipmentsDao->find($driver_id);
    }
}
