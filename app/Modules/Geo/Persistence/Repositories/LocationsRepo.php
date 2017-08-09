<?php

namespace App\Modules\Geo\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Geo\Domain\Entities\Location;
use App\Modules\Geo\Persistence\Catalogs\LocationsCollection;
use App\Modules\Geo\Persistence\Dao\LocationsDao;
use App\Modules\Geo\Persistence\Dao\Redis\RedisLocationsRelationsDao;
use Illuminate\Support\Collection;

class LocationsRepo
{
    private $locationsDao;
    private $redisLocsRelsDao;

    public function __construct(LocationsDao $locationsDao, RedisLocationsRelationsDao $redisLocsRelsDao)
    {
        $this->locationsDao = $locationsDao;
        $this->redisLocsRelsDao = $redisLocsRelsDao;
    }

    public function getLocationsWithNexts()
    {
        $worldMap = EntityStore::get(LocationsCollection::class, 0);

        if (null !== $worldMap) {
            return $worldMap;
        }

        // get locations from db
        $locationsData = $this->locationsDao->getLocations();

        // create entities Locations and filling it data
        $worldMap = new LocationsCollection();
        
        // collection of simple locations
        foreach ($locationsData as $locationData) {

            $location = new Location($locationData);

            $worldMap->addLocation($location);
        }
        

        // adding next locations
        /** @var Location $locationItem */
        foreach ($worldMap->locations as $locationItem) {
            
//            $nextIds = $this->locationsDao->getNextIdsBy($locationItem->id);
            $nextIds = $this->redisLocsRelsDao->getNextsByLocation($locationItem->id);

            foreach ($nextIds as $nextId) {
                
                $nextLocation = $worldMap->find($nextId);
                $locationItem->addNext($nextLocation);
            }
        }

        EntityStore::add($worldMap, 0);
        
        return $worldMap;
    }

    public function createLocation($title)
    {
        $location_id = $this->locationsDao->create($title);
        
        return $location_id;
    }

    public function find($id)
    {
        $locationData = $this->locationsDao->find($id);
        
        return new Location($locationData);
    }


    /** @deprecated */
    public static function geoListLocationsPage(LocationsCollection $locations)
    {
        $locationsRows = [];

        foreach ($locations as $location) {

            $nextLocations_ids = $location->locationsTo->map(function ($item, $key) {
                return $item->id;
            })->toArray();

            $nextLocationsTitles = $location->locationsTo->map(function ($item, $key) {
                return $item->title;
            })->toArray();

            $excludingLocations_ids = $nextLocations_ids;
            $excludingLocations_ids[] = $location->id;

            $otherLocations = $locations->reject(function ($item, $key) use ($excludingLocations_ids) {
                return in_array($item->id, $excludingLocations_ids);
            })->pluck('title', 'id');

            $columns = [
                'title' => $location->title,
                'nextLocationsTitles' => $nextLocationsTitles,
                'otherLocations' => $otherLocations,
            ];

            $locationsRows[$location->id] = $columns;
        }

        return $locationsRows;
    }

    public function bindLocations($from_id, $to_id)
    {
        $this->locationsDao->createRelation($from_id, $to_id);

        $this->redisLocsRelsDao->addByLocation($from_id, $to_id);
    }

    public function removePath($from_id, $to_id)
    {
        $this->locationsDao->removeRelation($from_id, $to_id);

        $this->redisLocsRelsDao->removeRelation($from_id, $to_id);
    }

}
