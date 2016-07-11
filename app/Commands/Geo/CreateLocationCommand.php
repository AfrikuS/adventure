<?php

namespace App\Commands\Geo;

use App\Models\Geo\Location;
use App\Repositories\Geo\LocationsRepository;

class CreateLocationCommand
{
    /** @var LocationsRepository */
    private $locationsRepo;

    public function __construct(LocationsRepository $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;
    }

    public function createLocation(string $title)
    {
        \DB::beginTransaction();
        try {

            $location = $this->locationsRepo->createLocation($title);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
        
        return $location;
    }
}
