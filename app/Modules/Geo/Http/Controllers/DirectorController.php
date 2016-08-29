<?php

namespace App\Modules\Geo\Http\Controllers;

class DirectorController extends PortController
{
    public function index()
    {
        return $this->view('geo.director', [
//            'shops' => $travelShips,
        ]);
    }
    
    public function buyLicense()
    {
        
    }
}
