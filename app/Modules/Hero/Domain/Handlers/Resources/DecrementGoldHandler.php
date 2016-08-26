<?php

namespace App\Modules\Hero\Domain\Handlers\Resources;

use App\Modules\Hero\Domain\Commands\Resources\DecrementGold;
use App\Persistence\Models\Hero;
use App\Persistence\Repositories\HeroRepo;

class DecrementGoldHandler
{
    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->heroRepo = app('HeroRepo');
    }

    public function handle(DecrementGold $command)
    {
        /** @var Hero $hero */
        $hero = $this->heroRepo->getHero($command->hero_id);

        
        $hero->decrementGold($command->amount);


        $this->heroRepo->updateResources($hero);
    }
}
