<?php

namespace App\Modules\Drive\View\Composers;

use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Illuminate\View\View;

class VehicleComposer
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct(VehiclesRepo $vehiclesRepo)
    {
        $this->vehiclesRepo = $vehiclesRepo;
    }

    public function compose(View $view)
    {
        $driver_id = $view->offsetGet('user_id');
        
        $vehicle = $this->vehiclesRepo->findViewVehicle($driver_id);

        $view->with('vehicle', $vehicle);
    }
}

