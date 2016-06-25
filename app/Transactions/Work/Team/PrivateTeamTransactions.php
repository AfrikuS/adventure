<?php

namespace App\Transactions\Work\Team;

use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker;
use App\Repositories\Work\PrivateTeamRepository;

class PrivateTeamTransactions
{
    public static function deleteTeamById($id)
    {
        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($id);

        \DB::transaction(function () use ($team) {

            foreach ($team->partners as $partner) {
                $partner->team_id = null;
                $partner->status = 'free';
                $partner->save();
            }

            $team->delete();
        });
    }

    public static function addWorkerToTeam(Worker $worker, PrivateTeam $team)
    {
        $team->partners()->save($worker);
    }

    public static function excludeWorkerFromTeam(Worker $worker, PrivateTeam $team)
    {
        \DB::transaction(function () use ($worker) {
            $worker->team_id = null;
            $worker->save();
        });
    }
}
