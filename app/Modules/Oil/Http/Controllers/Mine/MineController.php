<?php

namespace App\Http\Controllers\Mine;

use App\Factories\MineFactory;
use App\Factories\WorkerFactory;
use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Models\Mine\Miner;
use App\Models\Work\Worker;

class MineController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $miner = Miner::find($user->id);
        if (null === $miner) {
            $miner = MineFactory::createMiner($user);
        }

        return $this->view('mine.mine_index', [
            'miner' => $miner,
        ]);
    }
}
