<?php

namespace App\Modules\Npc\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Npc\Domain\Entities\NpcDeal;
use App\Modules\Npc\Persistence\Dao\DealsDao;

class DealsRepo
{
    private $offersDeals;

    public function __construct(DealsDao $offersDeals)
    {
        $this->offersDeals = $offersDeals;
    }

    public function getBy($user_id)
    {
        $dealsData = $this->offersDeals->getDealsBy($user_id);

        return $dealsData;
    }

    public function find($deal_id)
    {
        $deal = EntityStore::get(NpcDeal::class, $deal_id);

        if (null !== $deal) {
            return $deal;
        }

        $dealData = $this->offersDeals->findDealById($deal_id);

        $deal = new NpcDeal($dealData);

        EntityStore::add($deal, $deal_id);

        return $deal;
    }

    public function update(NpcDeal $deal)
    {
        $this->offersDeals->updateDeal(
            $deal->id, 
            $deal->deal_status, 
            $deal->deal_ending 
        );
    }
}
