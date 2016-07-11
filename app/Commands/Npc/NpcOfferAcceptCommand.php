<?php

namespace App\Commands\Npc;

use App\Repositories\Npc\NpcDealRepository;
use App\Repositories\Npc\OfferRepository;
use App\Entities\Npc\NpcOfferEntity;
use Carbon\Carbon;

class NpcOfferAcceptCommand
{
    /** @var NpcDealRepository  */
    private $dealRepo;

    public function __construct(NpcDealRepository $dealRepo)
    {
        $this->dealRepo = $dealRepo;
    }

    public function acceptOffer(int $offer_id)
    {
        /** @var NpcOfferEntity */
        $offerEntity = $this->dealRepo->findOfferById($offer_id);
        
        $dealEnding = Carbon::create()->addHours(24);

        // without transactoin cause single query
        $offerEntity->accept($dealEnding);
        
    }
}
