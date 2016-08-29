<?php

namespace App\Modules\Geo\Actions;

use App\Modules\Geo\Persistence\Repositories\LocationsRepo;

class CreateLocationCommand
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct()
    {
        $this->locationsRepo = app('LocationsRepo');
    }

    public function createLocation(string $title)
    {
        \DB::beginTransaction();
        try {

            $this->locationsRepo->createLocation($title);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
        
    }
}
