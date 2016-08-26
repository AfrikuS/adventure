<?php

namespace App\Modules\Work\Controllers\Admin\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use Illuminate\Support\Facades\Input;

class CatalogsController extends Controller
{
    public function index()
    {
        $materials = Material::get();
        $instruments = Instrument::get();
        $skills = Skill::get();

        return $this->view('admin.work.catalogs', [
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
        ]);
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
