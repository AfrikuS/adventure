<?php

namespace App\Modules\Auction\Persistence\Repositories;

use App\Modules\Auction\Domain\Entities\Thing;
use App\Modules\Auction\Persistence\Dao\ThingsDao;

class ThingsRepo
{
    /** @var ThingsDao */
    private $thingsDao;

    public function __construct(ThingsDao $things)
    {
        $this->thingsDao = $things;
    }
    
    public function update(Thing $thing)
    {
        $this->thingsDao->update(
            $thing->id, 
            $thing->status, 
            $thing->owner_id);
    }

    public function find($id)
    {
        $thingData = $this->thingsDao->find($id);
        
        return new Thing($thingData);
    }
}
