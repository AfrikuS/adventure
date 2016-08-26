<?php

namespace App\Modules\Hero\Domain\Handlers\Resources;

use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use App\Modules\Hero\Domain\Entities\Hero;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;

class IncrementGoldHandler
{
    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->heroRepo = app('HeroRepo');
    }

    public function handle(IncrementGold $command)
    {
        /** @var Hero $hero */
        $hero = $this->heroRepo->getHero($command->hero_id);

        
        $hero->incrementGold($command->amount);


        $this->heroRepo->updateResources($hero);
    }
}
