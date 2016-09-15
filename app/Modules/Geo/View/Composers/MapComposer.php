<?php

namespace App\Modules\Geo\View\Composers;

use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use Illuminate\View\View;

class MapComposer
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct(LocationsRepo $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;
    }

    public function compose(View $view)
    {
        $locationsCollection = $this->locationsRepo->getLocationsWithNexts();

        $view->with('locationsCollection', $locationsCollection->locations);
    }
}
