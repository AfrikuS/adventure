<?php

namespace App\Http\Controllers\Work;

use App\Factories\WorkFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Worker;

class WorkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (null === Worker::find($user->id)) {
            WorkFactory::createWorker($user);
        }

        return $this->view('work.work_index', [
        ]);
    }
}
