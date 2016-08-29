<?php

namespace App\Modules\Geo\Persistence\Repositories;

use App\Modules\Geo\Domain\Entities\Ship;
use App\Modules\Geo\Persistence\Dao\ShipsDao;

class ShipsRepo
{
    /** @var ShipsDao */
    private $shipsDao;

    public function __construct(ShipsDao $shipsDao)
    {
        $this->shipsDao = $shipsDao;
    }

    public function create()
    {
        
    }

    public function update(Ship $ship)
    {
        
    }

    public function getByOwner($owner_id)
    {
        $shipsData = $this->shipsDao->getByOwner($owner_id);

        return $shipsData;
    }

    public function getByRoute($route_id)
    {
        $shipsData = $this->shipsDao->getByRoute($route_id);
        
        return $shipsData;
    }
}
