<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use Illuminate\Support\Facades\Input;

class WorkCatalogsController extends Controller
{
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
