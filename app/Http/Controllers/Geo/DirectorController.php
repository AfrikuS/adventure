<?php

namespace App\Http\Controllers\Geo;

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
