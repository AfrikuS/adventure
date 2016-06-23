<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Work\Team\TeamWorkerRepository;

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
