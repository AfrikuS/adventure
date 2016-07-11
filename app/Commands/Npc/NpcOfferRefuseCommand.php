<?php

namespace App\Commands\Npc;

use App\Models\Npc\NpcDeal;
use App\Entities\Npc\NpcOfferEntity;
use App\Repositories\Npc\NpcDealRepository;

class NpcOfferRefuseCommand
{
    /** @var NpcDealRepository  */
    private $dealRepo;

    public function __construct(NpcDealRepository $dealRepo)
    {
        $this->dealRepo = $dealRepo;
    }
    
    public function refuseOffer(int $offer_id)
    {
        /** @var NpcOfferEntity */
        $offerEntity = $this->dealRepo->findOfferById($offer_id);

        $offerEntity->refuse();
        
    }
}
