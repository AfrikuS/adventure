<?php

namespace App\Modules\Geo\Http\Controllers;

use App\Modules\Core\Http\Controller;

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
