<?php

namespace App\Modules\Drive\Actions\Garage\Workroom;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Repairer;
use App\Modules\Drive\Domain\Services\Garage\Workroom\EquipmentsService;
use App\Modules\Drive\Persistence\Repositories\Workroom\RepairerRepo;
use Finite\Exception\StateException;

class RepairerUpgradeAction
{
    /** @var  RepairerRepo */
    private $repairerRepo;

    public function __construct()
    {
        $this->repairerRepo = app('RepairerRepo');
    }

    public function upgrade($driver_id)
    {
        /** @var Repairer $repairer */
        $repairer = $this->repairerRepo->findBy($driver_id);

        $this->validateAction($repairer);


        $equipmentService = new EquipmentsService();

        $equipmentService->upgradeRepairer($repairer);

    }

    private function validateAction(Repairer $repairer)
    {
        if ($repairer->isFullUpgrade()) {

            throw new StateException('Заправщик прокачан по максимуму');
        }
    }

}
