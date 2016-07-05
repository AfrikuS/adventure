<?php

namespace App\Http\Controllers\Work;

use App\Factories\WorkerFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Worker;

class WorkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (null === Worker::find($user->id)) {
            WorkerFactory::createWorker($user);
        }

        return $this->view('work.work_index', [
        ]);
    }

    protected function view($view = null, $data = [])
    {
//        $id = \Auth::id();
//        $res = \App\Models\Macro\Resources::select(['water', 'food', 'tree', 'free_people'])->find($id);
//        $heroResources = \App\Models\Core\Hero::select(['water', 'oil', 'gold'])->find($id);
//        $team = User::whe



        return parent::view($view, $data, [
//            'resources' => $res,
//            'heroResources' => $heroResources,
        ]);
    }

}
