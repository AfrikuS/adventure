<?php

namespace App\Modules\Battle\Domain\Services;

use App\Modules\Battle\Persistence\Repository\AttacksRepo;
use Carbon\Carbon;

class AttackService
{
    /** @var AttacksRepo */
    private $attacksRepo;

    public function __construct()
    {
        $this->attacksRepo = app('AttacksRepo');
    }

    public function addAttackEvent($atacker_id, $defenser_id)
    {
        $timeout = Carbon::now()->addMinutes(1)->addSeconds(8);
        
        $this->attacksRepo->addAttackEvent($atacker_id, $defenser_id, $timeout);
    }

/*    public function insertAttackEvent($atacker_id, $defenser_id, Carbon $moment)
    {
        $attackExist = \DB::table('event_attacks')
            ->whereExists(function($query) use($atacker_id, $defenser_id)
            {

                $query->select(DB::raw(1))
                    ->from('event_attacks')
                    ->where('defense_user_id', $defenser_id)
                    ->where('attack_user_id', $atacker_id);
            })
            ->get();

        if ($attackExist) {
            
            $this->attacksRepo->addAttackEvent($atacker_id, , )
        }
        else {
            create
        }
    }*/

}
