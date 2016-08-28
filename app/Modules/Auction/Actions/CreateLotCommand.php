<?php

namespace App\Modules\Auction\Actions;

use App\Models\Auth\User;
use App\Modules\Auction\Domain\Entities\Thing;
use App\Modules\Auction\Domain\Services\AuctionService;
use App\Modules\Auction\Persistence\Repositories\ThingsRepo;
use Finite\Exception\StateException;

class CreateLotCommand
{
    /** @var  ThingsRepo */
    private $thingsRepo;

    public function __construct()
    {
        $this->thingsRepo = app('ThingsRepo');
    }

    public function createLot(int $thing_id, int $user_id, int $bidAmount)
    {
        $thing = $this->thingsRepo->find($thing_id);

        $this->validateAction($thing, $user_id);

        $users = app('UsersRepo');

        $user = $users->find($user_id);

        $auctionService = new AuctionService(); 
        
        \DB::beginTransaction();
        try {


            $auctionService->createLot($thing, $user, $bidAmount);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }


        \DB::commit();
    }

    private function validateAction(Thing $thing, $user_id)
    {
        if ($thing->owner_id !== $user_id || $thing->status !== Thing::STATUS_FREE) {

            throw new StateException;
        }
    }
}
