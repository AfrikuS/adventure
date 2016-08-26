<?php

namespace App\Modules\Hero\Persistence\Repositories;

use App\Infrastructure\IdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Hero\Domain\Entities\Buildings;
use App\Modules\Hero\Persistence\Dao\BuildingsDao;

class BuildingsRepo
{
    private $buildingsDao;

    public function __construct(BuildingsDao $buildingsDao)
    {
        $this->buildingsDao = $buildingsDao;
    }

    public function getByHero($hero_id)
    {
        $buildings = EntityStore::get(Buildings::class, 'hero'.$hero_id);

        if (null != $buildings) {

            return $buildings;
        }

        $buildingsData = $this->buildingsDao->getByHero($hero_id);


        $buildings = new Buildings($buildingsData);

        
        EntityStore::add($buildings, 'hero'.$hero_id);
        
        return $buildings;
    }
}
