<?php

namespace App\Commands\Npc;

use App\Entities\Npc\NpcOfferEntity;
use App\Exceptions\TooLongNpcOfferWaitingException;
use App\Repositories\Npc\NpcDealRepository;
use Carbon\Carbon;

class DemonstrateNpcOfferCommand
{
    /** @var NpcDealRepository  */
    private $dealRepo;

    public function __construct(NpcDealRepository $dealRepo)
    {
        $this->dealRepo = $dealRepo;
    }

    public function demonstrateOffer(NpcOfferEntity $npcOffer)
    {
//        /** @var NpcOfferEntity */
//        $offerEntity = $this->dealRepo->findOfferById($offer_id);

//        $offerEntity->refuse();

        if ($npcOffer->isOfferExpired()) {
            $npcOffer->tooLongWait();

            throw new TooLongNpcOfferWaitingException;
        }


//        \DB::beginTransaction();
//        try {
//
            $offerEnding = Carbon::create()->addHours(2);

            $npcOffer->show($offerEnding);

//        }
//        catch(\Exception $e) {
//            \DB::rollBack();
//            throw  $e;
//        }
//
//        \DB::commit();
    }

}
