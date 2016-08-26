<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Drive\Catalogs\DetailKind;
use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use Gate;

class AdminController extends Controller
{
    public function index()
    {

        return $this->view('admin.index', [
        ]);
    }

    public function normalizeUser($id)
    {
        
    }

}
