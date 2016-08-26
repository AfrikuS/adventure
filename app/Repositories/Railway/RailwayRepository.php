<?php

namespace App\Repositories\Railway;

use App\Models\Railway\StationLicense;
use App\Models\Railway\TransitTrain;

class RailwayRepository
{

    public function findLicenseByHeroId($hero_id)
    {
        return StationLicense::
                select('id', 'level', 'status', 'end_time')
                ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
                ->find($hero_id);
        // railway_station_licenses.
    }

    public function findTrainById($id)
    {
        return TransitTrain::find($id);
    }
}
