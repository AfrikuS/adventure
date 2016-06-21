<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\HeroResources;
use App\Models\Work\ShopMaterial;
use App\Models\Work\Team\TeamWorker;
use App\Models\Work\UserMaterial;
use App\Repositories\ShopRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use Illuminate\Support\Facades\Input;

class WorkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // protect access to this page todo
        TeamWorkerRepository::findOrCreate($user);

        return $this->view('work/work_index', [
        ]);
    }
}
