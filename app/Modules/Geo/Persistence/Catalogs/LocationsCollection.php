<?php

namespace App\Modules\Geo\Persistence\Catalogs;

use App\Modules\Geo\Domain\Entities\Location;

class LocationsCollection
{
    public $locations;

    public function __construct()
    {
        $this->locations = [];
    }

    public function addLocation(Location $location)
    {
        $this->locations[$location->id] = $location;
    }

    public function find($id)
    {
        return $this->locations[$id];
    }

    // to presenter
    public function getViewSelect()
    {
        $options = array_pluck($this->locations, 'title', 'id');

        return $options;
    }

    // to presenter
    public function getNextsViewSelect($id)
    {
        $location = $this->locations[$id];


        $options = array_pluck($location->nextLocations, 'title', 'id');

        return $options;
    }
    
    public function getExcludeIds($id) // exlude self_id
    {
        $all_ids = array_keys($this->locations);

        $exclude_ids = array_filter($all_ids, function ($item) use ($id) {

            return $item !== $id;
        });

        return $exclude_ids;
    }

    private function getLocationsByIds(array $ids)
    {
        $locations = [];

        foreach ($ids as $id) {

            $locations[] = $this->locations[$id];
        }

        return $locations;
    }

    public function getPotentialNexts($location_id)
    {
        $potentialNext_ids = $this->getPotentialIds($location_id);

        $potentials = $this->getLocationsByIds($potentialNext_ids);
        
        return $potentials;
    }

    private function getPotentialIds($location_id)
    {
//        $potentialNext_ids = $this->getExcludeIds($location_id);

        $all_ids = array_keys($this->locations);
        $location = $this->locations[$location_id];
        $next_ids = array_keys($location->nextLocations);

        $potentialNext_ids = array_diff($all_ids, $next_ids, [$location_id]);

        return $potentialNext_ids;
    }
}
