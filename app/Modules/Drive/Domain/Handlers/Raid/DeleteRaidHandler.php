<?php

namespace App\Modules\Drive\Domain\Handlers\Raid;

use App\Modules\Drive\Domain\Commands\Raid\DeleteRaid;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;

class DeleteRaidHandler
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');;
    }

    public function handle(DeleteRaid $command)
    {
        $this->raidRepo->deleteRaid($command->raid_id);
    }
}
