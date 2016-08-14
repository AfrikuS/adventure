<?php

namespace App\Domain\Events\Hero;

use App\Persistence\Models\Hero;
use App\Persistence\Repositories\HeroRepo;

class IncrementGoldEvent
{
    /** @var HeroRepo */
    private $heroRepo;

    public function __construct(HeroRepo $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function handle($hero_id, $amount)
    {
        /** @var Hero $hero */
        $hero = $this->heroRepo->getHero($hero_id);

        $hero->incrementGold($amount);

        
        $this->heroRepo->updateResources($hero);
    }

}
