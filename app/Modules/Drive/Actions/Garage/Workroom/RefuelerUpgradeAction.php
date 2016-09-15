<?php

namespace App\Modules\Drive\Actions\Garage\Workroom;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Refueler;
use App\Modules\Drive\Domain\Services\Garage\Workroom\EquipmentsService;
use App\Modules\Drive\Persistence\Repositories\Workroom\RefuelerRepo;
use Finite\Exception\StateException;

class RefuelerUpgradeAction
{
    /** @var  RefuelerRepo */
    private $refuelerRepo;

    public function __construct()
    {
        $this->refuelerRepo = app('RefuelerRepo');
    }

    public function upgrade($driver_id)
    {
        /** @var Refueler $refueler */
        $refueler = $this->refuelerRepo->findBy($driver_id);

        $this->validateAction($refueler);


        $equipmentService = new EquipmentsService();

        $equipmentService->upgradeRefueler($refueler);

    }

    private function validateAction(Refueler $refueler)
    {
        if ($refueler->isFullUpgrade()) {

            throw new StateException('Заправщик прокачан по максимуму');
        }
    }

}
