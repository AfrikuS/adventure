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

    public function generateWorkOrder()
    {
        EntityGenerator::createWorkOrderWithMaterials();
        return redirect()->route('work_orders_page');
    }

    public function generateWorkTeamOrder()
    {
        EntityGenerator::createTeamWorkOrderWithMaterials();
        return redirect()->route('work_teamorders_page');
    }

    public function deleteWorkOrder($id)
    {
        EntityGenerator::deleteWorkOrder($id);
        return redirect()->route('work_orders_page');
    }
    public function deleteWorkTeamOrder($id)
    {
        EntityGenerator::deleteTeamWorkOrder($id);
        return redirect()->route('work_teamorders_page');
    }

    public function createMaterial()
    {
        $data = Input::all();
        $code = $data['code'];
        $title = $data['title'];

        Material::create([
            'code' => $code,
            'title' => $title,
        ]);

        return redirect()->route('admin_page');
    }

    public function createSkill()
    {
        $data = Input::all();
        $code = $data['code'];
        $title = $data['title'];

        Skill::create([
            'code' => $code,
            'title' => $title,
        ]);

        return redirect()->route('admin_page');
    }

    public function createInstrument()
    {
        $data = Input::all();
        $code = $data['code'];
        $title = $data['title'];

        Instrument::create([
            'code' => $code,
            'title' => $title,
        ]);

        return redirect()->route('admin_page');
    }

}
