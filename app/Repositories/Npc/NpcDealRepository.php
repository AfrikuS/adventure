<?php

namespace App\Repositories\Npc;

use App\Entities\Npc\NpcDealEntity;
use App\Entities\Npc\NpcOfferEntity;
use App\Models\Npc\NpcDeal;

class NpcDealRepository
{
    public function findOfferById($id)
    {
        $offer = NpcDeal::find($id);
        
        return new NpcOfferEntity($offer);
    }
    
    public function findDealEntityById($id)
    {
        $deal = NpcDeal::find($id);
        
        return new NpcDealEntity($deal);
    }
}
