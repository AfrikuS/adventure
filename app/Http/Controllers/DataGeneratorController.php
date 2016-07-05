<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Repositories\Generate\EntityGenerator;
use Illuminate\Support\Facades\Input;

class DataGeneratorController extends Controller
{
    public function generateTravel()
    {
        EntityGenerator::createSeaTravel();
        return redirect()->route('sea_travels_page');
    }

    public function deleteTravel($id)
    {
        EntityGenerator::deleteSeaTravel($id);
        return redirect()->route('sea_travels_page');
    }


    public function generateWorkTeamOrder()
    {
        EntityGenerator::createTeamWorkOrderWithMaterials();
        return redirect()->route('work_teamorders_page');
    }
}
