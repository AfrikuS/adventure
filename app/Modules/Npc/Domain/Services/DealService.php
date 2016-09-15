<?php

namespace App\Modules\Npc\Domain\Services;

use App\Modules\Npc\Domain\Entities\NpcDeal;
use App\Modules\Npc\Persistence\Repositories\DealsRepo;
use Carbon\Carbon;

class DealService
{
    /** @var DealsRepo */
    private $deals;

    public function __construct()
    {
        $this->deals = app('DealsRepo');
    }

    public function activateDeal(NpcDeal $deal)
    {
        $dealEnding = Carbon::create()->addHours(24);
        $deal->init($dealEnding);


        $this->deals->update($deal);
    }
}
