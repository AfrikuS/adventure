<?php

namespace App\Commands\Work\Team;

use App\Exceptions\WorkerBelongTeamException;
use App\Models\Work\Team\TeamJoinOffer;
use App\Models\Work\Worker;

class OfferJoinToTeamCommand
{
    public function createOfferJoin(Worker $worker, $team_id)
    {
        if ($worker->team_id != null) {
            throw new WorkerBelongTeamException;
        }

        $offer = TeamJoinOffer::create([
            'worker_id' => $worker->id,
            'team_id' => $team_id,
        ]);
    }
}
