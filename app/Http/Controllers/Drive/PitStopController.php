<?php

namespace App\Http\Controllers\Drive;

use App\Http\Controllers\Controller;

class PitStopController extends DriveController
{
    public function index()
    {

        return $this->view('drive.pit_stop', [
        ]);
    }

    public function diagnosticVehicle($id)
    {
//        $vehicle;
//        $troubles = diagnostic($vehicle);

//        show troubles:   curr: 45 % < max: 100 %
    }

    public function serviceVehicleBody()
    {

    }
    public function serviceVehicleSuspension() // подвеска
    {
//        traction control system
//        engine
    }
}
