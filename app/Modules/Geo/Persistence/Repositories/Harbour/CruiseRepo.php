<?php

namespace App\Modules\Geo\Persistence\Repositories\Harbour;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Geo\Domain\Entities\Harbour\Cruise;
use App\Modules\Geo\Persistence\Dao\Harbour\CruiseDao;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;

class CruiseRepo
{
    /** @var CruiseDao */
    private $cruiseDao;
    
    /** @var LocationsRepo */
    private $locations;

    public function __construct(CruiseDao $cruiseDao)
    {
        $this->cruiseDao = $cruiseDao;
        
        $this->locations = app('LocationsRepo');
    }

    public function find($id)
    {
        return $this->cruiseDao->find($id);
    }

    public function findBy($user_id)
    {
        $cruise = EntityStore::get(Cruise::class, 'user'.$user_id);

        if (null != $cruise) {

            return $cruise;
        }

        $cruiseData = $this->cruiseDao->findBy($user_id);


        $cruise = new Cruise($cruiseData);

        
        
        EntityStore::add($cruise, 'user'.$user_id);

        return $cruise;


//
//        return $this->cruiseDao->findBy($user_id);
//
//
//
//        $voyage = LiveVoyage::select('id', 'location_id', 'status', 'traveler_id')
//            ->where('traveler_id', $this->user_id)
//            ->with(['location' => function ($query) {
//                $query->select('id', 'title')
//                    ->with(['locationsTo' => function ($query) {
//                        $query->select('geo_locations.title', 'geo_locations.id');
//                    }]);
//            }])
//            ->first();
//
    }

    public function update($cruise, $nextLocation_id, $status)
    {
        return
            $this->cruiseDao->update(
                $cruise->id,
                $nextLocation_id,
                $status
            );
    }
}
