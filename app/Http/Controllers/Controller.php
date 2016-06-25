<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
        $id = \Auth::id();
        $res = \App\Models\Macro\Resources::select(['water', 'food', 'tree', 'free_people'])->find($id);
        $heroResources = \App\Models\Hero\Resources::select(['water', 'oil', 'gold'])->find($id);
//        $team = User::whe

        return view($view, $data, [
            'resources' => $res,
            'heroResources' => $heroResources,
        ]);
    }
}
