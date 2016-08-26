<?php

namespace App\Modules\Npc\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Npc\Domain\Entities\NpcOffer;
use App\Modules\Npc\Persistence\Dao\DealsDao;

class OffersRepo
{
    private $offersDeals;

    public function __construct(DealsDao $offersDeals)
    {
        $this->offersDeals = $offersDeals;
    }

    public function create($user_id, $character, $task, $reward)
    {
        return
            $this->offersDeals->create(
                $user_id,
                $character, 
                $task, 
                $reward
            );
    }
    
    public function getBy($user_id)
    {
        $offersData = $this->offersDeals->getOffersBy($user_id);
        
        return $offersData;
    }

    public function find($offer_id)
    {
        $offer = EntityStore::get(NpcOffer::class, $offer_id);
        
        if (null !== $offer) {
            return $offer;
        }
        
        $offerData = $this->offersDeals->findOfferById($offer_id);
        
        $offer = new NpcOffer($offerData); 
        
        EntityStore::add($offer, $offer_id);
        
       return $offer;
    }

    public function updateStatus(NpcOffer $offer)
    {
        $this->offersDeals->updateOffer(
            $offer->id,
            $offer->offer_status,
            $offer->offer_ending
        );
    }

    public function delete($offer_id)
    {
        $this->offersDeals->delete($offer_id);
    }
}
