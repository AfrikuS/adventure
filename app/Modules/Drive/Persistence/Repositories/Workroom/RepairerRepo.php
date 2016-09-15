<?php

namespace App\Modules\Drive\Persistence\Repositories\Workroom;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Repairer;
use App\Modules\Drive\Persistence\Dao\Workroom\EquipmentsDao;

class RepairerRepo
{
    /** @var EquipmentsDao */
    private $equipmentsDao;

    public function __construct(EquipmentsDao $equipmentsDao)
    {
        $this->equipmentsDao = $equipmentsDao;
    }

    public function findBy($driver_id)
    {
        $repairerData = $this->equipmentsDao->findRepairerBy($driver_id);

        $repairer = new Repairer($repairerData);

        return $repairer;
    }

    public function updateLevel(Repairer $repairer)
    {
        $this->equipmentsDao->updateRepairer(
            $repairer->driver_id,
            $repairer->level
        );
    }
}
