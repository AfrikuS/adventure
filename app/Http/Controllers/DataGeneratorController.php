<?php

namespace App\Http\Controllers;

use App\Models\Work\WorkMaterial;
use App\Models\Work\WorkInstrument;
use App\Models\Work\WorkSkill;
use App\Repositories\Generate\EntityGenerator;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
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

        WorkMaterial::create([
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

        WorkSkill::create([
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

        WorkInstrument::create([
            'code' => $code,
            'title' => $title,
        ]);

        return redirect()->route('admin_page');
    }

}
