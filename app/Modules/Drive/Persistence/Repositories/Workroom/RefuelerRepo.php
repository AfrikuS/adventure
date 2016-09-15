<?php

namespace App\Modules\Drive\Persistence\Repositories\Workroom;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Refueler;
use App\Modules\Drive\Persistence\Dao\Workroom\EquipmentsDao;

class RefuelerRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }

    public function findBy($driver_id)
    {
        $refuelerData = $this->equipmentsDao->findRefuelerBy($driver_id);

        $refueler = new Refueler($refuelerData);

        return $refueler;
    }

    public function updateLevel(Refueler $refueler)
    {
        $this->equipmentsDao->updateRefueler(
            $refueler->driver_id,
            $refueler->level
        );
    }
}
