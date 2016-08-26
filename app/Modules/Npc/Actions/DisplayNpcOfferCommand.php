<?php

namespace App\Modules\Npc\Actions;

use App\Entities\Npc\NpcOfferEntity;
use App\Exceptions\TooLongNpcOfferWaitingException;
use App\Repositories\Npc\NpcDealRepository;
use Carbon\Carbon;

class DisplayNpcOfferCommand
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


//        }
//        catch(\Exception $e) {
//            \DB::rollBack();
//            throw  $e;
//        }
//
//        \DB::commit();
    }

}
