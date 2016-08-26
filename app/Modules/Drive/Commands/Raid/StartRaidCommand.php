<?php

namespace App\Modules\Drive\Commands\Raid;

use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use Carbon\Carbon;

class StartRaidCommand
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
    }

    public function createRaid($driver_id, $vehicle_id)
    {
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
        $raid = $this->raidRepo->findSimpleRaid($driver_id);

        return $raid != null;
    }

}
