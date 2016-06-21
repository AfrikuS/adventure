<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Catalogs\WorkInstrument;
use App\Models\Work\Catalogs\WorkMaterial;
use App\Models\Work\Catalogs\WorkSkill;

class AdminController extends Controller
{
    public function index()
    {
//        Action::create(['title' => 'Уйти в дозор', 'code' => 'dozor', 'duration_seconds' => 15 * 60]);
//        Action::create(['title' => 'Бодаться', 'code' => 'bodalka', 'duration_seconds' => 5]);
//        Action::create(['title' => 'Работать в кузнице', 'code' => 'smith', 'duration_seconds' => 6]);
//        Action::create(['title' => 'Добывать нефть', 'code' => 'oil_hole', 'duration_seconds' => 4]);

//        User::create([
//            'name' => 'test6',
//            'email' => 'test6' . '@mail.com',
//            'password' => bcrypt(123),
//        ]);

//        HeroResources::init();

        $materials = WorkMaterial::get();
        $instruments = WorkInstrument::get();
        $skills = WorkSkill::get();


        return $this->view('admin/index', [
            'materials' => $materials,
            'instruments' => $instruments,
            'skills' => $skills,
        ]);
    }
}
