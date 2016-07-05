<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use Gate;

class AdminController extends Controller
{
    public function index()
    {

//        Gate::index();

        $materials = Material::get();
        $instruments = Instrument::get();
        $skills = Skill::get();
        
        return $this->view('admin.index', [
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
        ]);
    }
}
