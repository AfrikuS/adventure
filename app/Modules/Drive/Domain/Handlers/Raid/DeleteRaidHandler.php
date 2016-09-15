<?php

namespace App\Modules\Drive\Domain\Handlers\Raid;

use App\Modules\Drive\Domain\Commands\Raid\FinishRaid;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;

class DeleteRaidHandler
{
    /** @var RaidsRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');;
    }

    public function handle(FinishRaid $command)
    {
        $this->raidRepo->deleteRaid($command->raid_id);
    }
}
