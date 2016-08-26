<?php

namespace App\Commands\Battle;

use App\Models\Auth\User;
use App\Repositories\AttackRepository;
use App\Repositories\Battle\TeaserRepository;
use Carbon\Carbon;

class AttackOpponentCommand
{
    /** @var  TeaserRepository */
    private $teaserRepo;

    public function __construct(TeaserRepository $teaserRepo)
    {
        $this->teaserRepo = $teaserRepo;
    }

    public function attack($atacker_id, $defenser_id)
    {
//        $atacker  = User::find($atacker_id);
//        $defenser = User::select('id', 'name')->find($defenser_id);

        $moment = Carbon::now()->addMinutes(1)->addSeconds(8);


        \DB::beginTransaction();
        try {

            $this->teaserRepo->insertAttackEvent($atacker_id, $defenser_id, $moment);

            $this->teaserRepo->addResourceChannel($atacker_id, $defenser_id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
