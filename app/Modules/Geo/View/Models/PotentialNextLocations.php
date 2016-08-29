<?php

namespace App\Modules\Geo\View\Models;

use App\Modules\Geo\Domain\Entities\Location;

class PotentialNextLocations
{
    public $potentialsMap;

    public function __construct()
    {
        $this->potentialsMap = [];
    }

    public function add($location_id, array $potentials)
    {
        $this->potentialsMap[$location_id] = $potentials;
    }

//    public function getPotentialsBy($location_id)
//    {
//        return $this->potentialsMap[$location_id];
//    }

    public function get($id)
    {
        return $this->potentialsMap[$id];
    }

    public function extract()
    {
        return $this->potentialsMap;
    }

    public function getPotentialsViewSelect($id)
    {
        $potentials = $this->potentialsMap[$id];


        $options = array_pluck($potentials, 'title', 'id');

        return $options;
    }
}
