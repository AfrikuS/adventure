<?php

namespace App\Modules\Battle\Domain\Services;

use App\Modules\Battle\Persistence\Repository\AttacksRepo;
use Carbon\Carbon;

class AttackService
{
    /** @var AttacksRepo */
    private $attacksRepo;

    public function __construct()
    {
        $this->attacksRepo = app('AttacksRepo');
    }

    public function addAttackEvent($atacker_id, $defenser_id)
    {
        $timeout = Carbon::now()->addMinutes(1)->addSeconds(8);
        
        $this->attacksRepo->addAttackEvent($atacker_id, $defenser_id, $timeout);
    }
}
