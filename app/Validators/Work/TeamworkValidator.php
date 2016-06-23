<?php

namespace Validators\Work;

use App\Models\Work\PrivateTeam;
use App\Repositories\TeamworkRepository;
use Illuminate\Database\Eloquent\Collection;

class TeamworkValidator
{
    public static function isWorkersReadyToWork(PrivateTeam $team)
    {
        $workers = TeamworkRepository::getWorkersByTeam($team);

        $readyWorkersCount = $workers->filter(function ($worker) {
            return $worker->status === 'ready';
        })->count();

        return $readyWorkersCount === $workers->count();
    }
}
