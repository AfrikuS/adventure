<?php

namespace App\Http\Controllers;

use App\Models\HeroResources;
use App\Models\Macro\Resources;
use App\Models\Work\Team\PrivateTeam;
use App\Repositories\HeroResourcesRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $user_id;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->user_id = auth()->user()->id;
        $this->user_id = auth()->id();
    }

    public function view($view = null, $data = [])
    {
        $id = \Auth()->id();
        $res = Resources::select(['water', 'food', 'tree', 'free_people'])->find($id);
        $heroResources = HeroResources::select(['water', 'oil', 'gold'])->find($id);
//        $team = User::whe

        return view($view, $data, [
            'resources' => $res,
            'heroResources' => $heroResources,
        ]);
    }
}
