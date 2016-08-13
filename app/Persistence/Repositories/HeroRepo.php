<?php

namespace App\Persistence\Repositories;

use App\Persistence\Dao\HeroDao;

class HeroRepo
{
    private $heroDao;

    public function __construct()
    {
        $this->heroDao  = new HeroDao();
    }

    public function updateResources($hero)
    {
        $this->heroDao->save($hero);
    }

    public function getHero($user_id)
    {
        return $this->heroDao->findById($user_id);
    }
}
