<?php

namespace App\Modules\Geo\Http\Controllers;

use App\Http\Controllers\Controller;

class DirectorController extends Controller
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
