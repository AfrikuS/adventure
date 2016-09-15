<?php

namespace App\Modules\Drive\Domain\Services\Garage\Workroom;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Refueler;
use App\Modules\Drive\Domain\Entities\Garage\Workroom\Repairer;
use App\Modules\Drive\Persistence\Repositories\Workroom\RefuelerRepo;
use App\Modules\Drive\Persistence\Repositories\Workroom\RepairerRepo;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;

class EquipmentsService
{
    /** @var  RefuelerRepo */
    private $refuelerRepo;
    
    /** @var RepairerRepo */
    private $repairerRepo;

    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->refuelerRepo = app('RefuelerRepo');
        $this->repairerRepo = app('RepairerRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function upgradeRefueler(Refueler $refueler)
    {
        $refueler->upgradeLevel();
        
        $this->refuelerRepo->updateLevel($refueler);
    }

    public function upgradeRepairer(Repairer $repairer)
    {
        $repairer->upgradeLevel();

        $this->repairerRepo->updateLevel($repairer);
    }
}
