<?php

namespace App\Modules\Hero\Persistence\Repositories;

use App\Modules\Hero\Domain\Entities\Hero;
use App\Modules\Hero\Persistence\Dao\HeroDao;

class HeroRepo
{
    private $heroDao;

    public function __construct(HeroDao $heroDao)
    {
        $this->heroDao  = $heroDao;
    }

    public function updateResources(Hero $hero)
    {
        $this->heroDao->update(
            $hero->id,
            $hero->gold,
            $hero->oil,
            $hero->water
        );
    }

    public function getHero($user_id)
    {
        $heroData = $this->heroDao->findById($user_id);

        return new Hero($heroData);
    }
}
