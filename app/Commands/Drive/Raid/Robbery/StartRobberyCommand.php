<?php

namespace App\Commands\Drive\Raid\Robbery;

use App\Entities\Drive\RaidEntity;
use App\Models\Drive\Robbery;
use App\Repositories\Drive\RaidRepository;
use Carbon\Carbon;

class StartRobberyCommand
{
    /** @var RaidRepository */
    private $raidRepo;

    public function __construct(RaidRepository $raidRepo)
    {
        $this->raidRepo = $raidRepo;
    }

    public function startRobbery(RaidEntity $raid)
    {
        
        $vehicle_id = $raid->vehicle_id;
        $driver_id  = $raid->id;


        
        if ($raid->isRobberyExist()) {
            
            return;
        }
        
        if ($raid->isVictimNotFinded()) {
            throw new \Exception;
        }


        \DB::beginTransaction();
        try {

            $raid->toRobberyOnVictim();

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

}
