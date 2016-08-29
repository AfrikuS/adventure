<?php

namespace App\Modules\Geo\Persistence\Repositories\Business;

use App\Modules\Geo\Domain\Entities\Business\Ship;
use App\Modules\Geo\Persistence\Dao\Business\ShipsDao;

class ShipsRepo
{
    /** @var ShipsDao */
    private $shipsDao;

    public function __construct(ShipsDao $shipsDao)
    {
        $this->shipsDao = $shipsDao;
    }

    public function create($owner_id)
    {
        $this->shipsDao->create($owner_id);
    }

    public function find($id)
    {
        $shipData = $this->shipsDao->find($id);
        
        return new Ship($shipData);
    }
    
    public function update(Ship $ship)
    {
        $this->shipsDao->update(
            $ship->id,
            $ship->route_id
        );
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

    public function getFreeByOwner($user_id)
    {
        $shipsData = $this->shipsDao->getFreeByOwner($user_id);

        return $shipsData;
    }
}
