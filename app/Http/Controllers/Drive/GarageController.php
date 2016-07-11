<?php

namespace App\Http\Controllers\Drive;


use App\Models\Drive\Catalogs\DetailKind;
use App\Models\Drive\Catalogs\DetailTitle;
use App\Models\Drive\Detail;
use App\Models\Drive\Driver;
use App\Models\Drive\Vehicle;
use Illuminate\Support\Facades\Redirect;

class GarageController extends AppController
{
    public function vehiclePage()
    {
    }

    public function repairPage()
    {

        return $this->view('drive.garage.repair', [
        ]);
    }
    
}
