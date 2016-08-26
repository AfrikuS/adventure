<?php

namespace App\Modules\Npc\Actions;

use App\Modules\Npc\Domain\Entities\NpcDeal;
use App\Modules\Npc\Domain\Entities\NpcOffer;
use App\Modules\Npc\Domain\Services\DealService;
use App\Modules\Npc\Domain\Services\OfferService;
use App\Modules\Npc\Persistence\Repositories\DealsRepo;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Carbon\Carbon;
use Finite\Exception\StateException;

class NpcOfferAcceptCommand
{
    /** @var OffersRepo */
    private $offers;

    /** @var DealsRepo */
    private $deals;

    public function __construct()
    {
        $this->offers = app('OffersRepo');
        $this->deals = app('DealsRepo');
    }

    public function acceptOffer(int $offer_id, int $user_id)
    {
        /** @var NpcOffer */
        $offer = $this->offers->find($offer_id);
        
        $this->validateAccept($offer);
        
        
        $offerService = new OfferService();

        // validate accepting
        $offerService->acceptOffer($offer);
        
        
        
        $dealService = new DealService();

        /** @var NpcDeal $deal */
        $deal = $this->deals->find($offer_id);


        // validate activating
        $dealService->activateDeal($deal);
        
        

    }

    private function validateAccept(NpcOffer $offer)
    {
        if ($offer->offer_status !== NpcOffer::STATUS_SHOWN) {
            throw new StateException;
        }
    }
}
