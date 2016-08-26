<?php

namespace App\Commands\Drive\Raid;

use App\Models\Core\Hero;
use App\Repositories\Drive\RaidRepository;
use App\Repositories\HeroRepositoryObj;

class FinishRaidCommand
{
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    /** @var RaidRepository */
    private $raidRepo;

    public function __construct(RaidRepository $raidRepo, HeroRepositoryObj $heroRepo)
    {
        $this->raidRepo = $raidRepo;
        $this->heroRepo = $heroRepo;
    }

    public function finishRaid($raid)
    {
        /** @var Hero */
        $hero = $this->heroRepo->findById($raid->id);

        \DB::beginTransaction();
        try {

            $this->heroRepo->incrementGold($hero, $raid->reward);
            
            $this->raidRepo->deleteRaid($raid->id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
