<?php

namespace App\Commands\Drive\Raid;

use App\Repositories\Drive\RaidRepository;
use Carbon\Carbon;

class StartRaidCommand
{
    /** @var RaidRepository */
    private $raidRepo;

    public function __construct(RaidRepository $raidRepo)
    {
        $this->raidRepo = $raidRepo;
    }

    public function createRaid($driver_id, $vehicle_id)
    {
//        $vehicle_id = $raid->vehicle_id;
//        $driver_id  = $raid->driver_id;


        if ($this->isRaidExist($driver_id)) {

            return;
        }


        \DB::beginTransaction();
        try {

            $startTime = Carbon::create()->toDateTimeString();

            $this->raidRepo->createRaid($driver_id, $vehicle_id, $startTime);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function isRaidExist($driver_id)
    {
        $raid = $this->raidRepo->findSimpleRaidById($driver_id);

        return $raid != null;
    }

}
