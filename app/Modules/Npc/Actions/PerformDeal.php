<?php

namespace App\Modules\Npc\Actions;

use App\Modules\Npc\Persistence\Repositories\DealsRepo;

class PerformDeal
{
    /** @var DealsRepo  */
    private $deals;

    public function __construct()
    {
        $this->deals = app('DealsRepo');
    }

    public function preform($deal_id)
    {
        $deal = $this->deals->find($deal_id);

        $deal->perform();

        $this->deals->update($deal);
    }
}
