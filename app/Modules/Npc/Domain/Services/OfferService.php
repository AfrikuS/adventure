<?php

namespace App\Modules\Npc\Domain\Services;

use App\Modules\Npc\Domain\Entities\NpcOffer;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Carbon\Carbon;

class OfferService
{
    /** @var OffersRepo */
    private $offers;


/*'created'     => ['type' => 'initial', 'properties' => []],
'shown'       => ['type' => 'normal', 'properties' => []],
'accepted'    => ['type' => 'final', 'properties' => []],
'refused'     => ['type' => 'final', 'properties' => []],
'expired'     => ['type' => 'final', 'properties' => []],*/



    public function __construct()
    {
        $this->offers = app('OffersRepo');
    }

    public function activateOfferTimer(NpcOffer $offer)
    {
        $offer->show();

        $offerEnding = Carbon::create()->addSeconds(96);

        $offer->initTimeCounter($offerEnding);

        
        
        $this->offers->updateStatus($offer);
    }

    public function cancelOffer(NpcOffer $offer)
    {
        $this->offers->delete($offer->id);
    }

    public function updateStatusAfterExpire(NpcOffer $offer)
    {
        $offer->tooLongWait();

        $this->offers->updateStatus($offer);
    }

    /**
     * @param NpcOffer $offer
     * @param $user_id
     */
    public function acceptOffer(NpcOffer $offer)
    {
        $offer->accept();

        $this->offers->updateStatus($offer);
    }
}
