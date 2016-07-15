<?php

namespace App\Http\Controllers\Drive\Garage;

use App\Http\Controllers\Drive\DriveController;
use Illuminate\Support\Facades\Redirect;

class WorkroomController extends DriveController
{
    public function index()
    {
        $vehicle = $this->vehicle;
        
        return $this->view('drive.garage.workroom', [
            'vehicle' => $vehicle,
        ]);
    }

    public function repair()
    {
        // просто починить
        $this->vehicle->repairOn(10);

        return Redirect::route('drive_workroom_page');
    }

    public function recovery()
    {
        // восстановить после поломки
        $this->vehicle->recoveryAfterBreaking();
        
        return Redirect::route('drive_workroom_page');
    }

    public function refuel()
    {
        // запправить топливом
        $this->vehicle->refuel(3);

        return Redirect::route('drive_workroom_page');
    }

}
