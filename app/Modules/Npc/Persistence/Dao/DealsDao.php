<?php

namespace App\Modules\Npc\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Modules\Npc\Domain\Entities\NpcDeal;
use App\Modules\Npc\Domain\Entities\NpcOffer;

class DealsDao
{
    private $table = 'npc_deals';

    public function findOfferById(int $id)
    {
        $offerData = \DB::table($this->table)
            ->select(['id', 'hero_id', 'npc_char', 'reward', 'task', 'offer_status', 'offer_ending'])
//            ->where('offer_status', 'created')
//            ->orWhere('offer_status', 'waiting')
            ->find($id);

        if (null === $offerData) {
            throw new EntityNotFound_Exception;
        }

        return $offerData;
    }

//'id';
//    protected $fillable   = ['hero_id', 'npc_char', 'task', 'reward',
//        'offer_status', 'offer_ending', 'deal_status', 'deal_ending'];


    public function getOffersBy($user_id)
    {
        $npcOffersData = \DB::table($this->table)
            ->select(['id', 'hero_id', 'task', 'offer_status', 'offer_ending'])
            ->where('hero_id', $user_id)
            ->where('deal_status', NpcDeal::STATUS_NO_STATUS)
            ->get();

        return $npcOffersData;
    }

    public function getDealsBy($user_id)
    {
        $npcDealsData = \DB::table($this->table)
            ->select(['id', 'hero_id', 'task', 'offer_status', 'offer_ending'])
            ->where('hero_id', $user_id)
            ->where('offer_status', 'accepted')
            ->get();

        return $npcDealsData;
    }

    public function delete($offer_id)
    {
        \DB::table($this->table)->delete($offer_id);
    }

    public function updateOffer($offer_id, $offer_status, $offer_ending)
    {
        \DB::table($this->table)
            ->where('id', $offer_id)
            ->update([
                'offer_status' => $offer_status,
                'offer_ending' => $offer_ending,
            ]);
    }

    public function updateDeal($deal_id, $deal_status, $deal_ending)
    {
        \DB::table($this->table)
            ->where('id', $deal_id)
            ->update([
                'deal_status' => $deal_status,
                'deal_ending' => $deal_ending,
            ]);
    }

    public function create($user_id, $character, $task, $reward)
    {
        $offer_id =
            \DB::table($this->table)
                ->insertGetId([
                    'hero_id' => $user_id,
                    'npc_char' => $character,
                    'task' => $task,
                    'reward' => $reward,
                    'offer_status' => NpcOffer::STATUS_CREATED,
                    'offer_ending' => null,
                    'deal_status' => NpcDeal::STATUS_NO_STATUS,
                    'deal_ending' => null,
                ]);

        return $offer_id;
    }

    public function findDealById($deal_id)
    {
        $dealData = \DB::table($this->table)
            ->select(['id', 'hero_id', 'npc_char', 'reward', 'task', 'deal_status', 'deal_ending'])
            ->find($deal_id);

        if (null === $dealData) {
            throw new EntityNotFound_Exception;
        }

        return $dealData;
    }
}
