<?php

namespace App\Modules\Npc\Actions;

use App\Models\Npc\NpcDeal;
use App\Entities\Npc\NpcOfferEntity;
use App\Modules\Npc\Domain\Entities\NpcOffer;
use App\Modules\Npc\Domain\Services\OfferService;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use App\Repositories\Npc\NpcDealRepository;

class NpcOfferRefuseCommand
{
    /** @var OffersRepo  */
    private $offers;

    public function __construct()
    {
        $this->offers = app('OffersRepo');
    }
    
    public function refuseOffer(int $offer_id)
    {
        /** @var NpcOffer */
        $offer = $this->offers->find($offer_id);

        $offerService = new OfferService();

        $offerService->cancelOffer($offer);
    }
}
