<?php

namespace App\Commands\Drive\Raid\Robbery;

use App\Entities\Drive\RobberyEntity;
use App\Models\Drive\Robbery;
use App\Repositories\Drive\RaidRepository;

class FinishRobberyCommand
{
    /** @var RaidRepository */
    private $raidRepo;

    public function __construct(RaidRepository $raidRepo)
    {
        $this->raidRepo = $raidRepo;
    }

    public function finishRobbery(RobberyEntity $robbery)
    {

        $raid = $this->raidRepo->findRaidById($robbery->id);

        $raid->completeRobbery();
//        $raid->addReward($robbery->reward);


        $this->raidRepo->deleteRobberyById($robbery->id);

    }
}
