<?php

namespace App\Commands\Trade\Auction;

use App\Factories\AuctionFactory;
use App\Models\User;
use App\Repositories\HeroRepositoryObj;
use App\Serializers\RedisAuctionLot;
use App\StateMachines\Trade\ThingStateMachine;

class CreateLotCommand
{
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(HeroRepositoryObj $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function createLot(int $thing_id, int $user_id, int $bidAmount)
    {
        $thing = $this->heroRepo->findThingById($thing_id);
        $user = User::find($user_id);

        if ($thing->owner_id != $user_id) {
            throw new \Exception('This Thing belong to other user');
        }

        \DB::beginTransaction();
        try {

            $lot = AuctionFactory::createLotByThing($thing, $user, $bidAmount);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        $thing->lock();
        RedisAuctionLot::saveLotInRedis($lot);

        \DB::commit();
    }
}
