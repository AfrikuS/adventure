<?php

namespace App\Repositories\Npc;

use App\Models\Npc\NpcDeal;

class OfferRepository
{
    public static function findById($id): NpcDeal
    {
        return NpcDeal::
            select('*')
//            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), npc_deals.offer_ending) AS duration_offer')
//            ->havingRaw('duration_offer > 0')
            ->find($id);

    }
}
