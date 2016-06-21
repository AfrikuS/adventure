<?php

namespace App\Domain\Game;

use App\Repositories\AttackRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fight
{
    public $atacker;
    public $defenser;

    public function __construct()
    {
    }

    /**
     * Fight constructor.
     * @param $atacker
     * @param $defenser
     */
    public function start($atacker_id, $defenser_id)
    {
//        $this->atacker = $atacker;
//        $this->defenser = $defenser;
        $moment = Carbon::now()->addHours(7);
        
        AttackRepository::insertAttackEvent($atacker_id, $defenser_id, $moment);
    }

}
