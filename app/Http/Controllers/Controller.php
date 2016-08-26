<?php

namespace App\Http\Controllers;

use App\Models\Npc\NpcDeal;
use App\Repositories\HeroRepositoryObj;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $user_id;
    
    public function __construct()
    {
        $this->user_id = \Auth::id();
    }

    protected function view($view = null, $data = [])
    {
//        $res = \App\Models\Macro\Resources::select(['water', 'food', 'tree', 'free_people'])->find($id);
        
        return view($view, $data, [
            'user_id' => $this->user_id,
        ]);
    }
}
