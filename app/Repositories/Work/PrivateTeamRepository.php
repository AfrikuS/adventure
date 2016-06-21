<?php

namespace App\Repositories\Work;

use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use Illuminate\Support\Facades\DB;

class PrivateTeamRepository
{
    public static function createPrivateTeamwork($worker, $kindWork = 'Mine of white balls')
    {
        return PrivateTeam::create([
            'leader_worker_id' => $worker->id,
            'kind_work' => $kindWork,
            'status' => 'free',
        ]);
    }

    public static function getAllTeamsWithWorkers()
    {
        return PrivateTeam::
            select('id', 'kind_work', 'status', 'leader_worker_id')
            ->with(['leader' => function ($query) {
                $query->select('id', 'team_id')
                    ->with(['user' => function ($query2) {
                        $query2->select('id', 'name');
                    }]);
            }])
            ->with(['partners' => function ($query) {
                $query->select('id', 'team_id')
                    ->with(['user' => function ($query2) {
                        $query2->select('id', 'name');
                    }]);
            }])
            ->get();
    }
    
    public static function getTeamWithCreatorAndPartnersById($id): PrivateTeam
    {
        $privateteam = PrivateTeam::
            with(['leader' => function ($query) {
                $query->select('id', 'team_id')
                    ->with(['user' => function ($query2) {
                        $query2->select('id', 'name');
                    }]);
            }])
            ->with(['partners' => function ($query) {
                $query->select('id', 'team_id')
                    ->with(['user' => function ($query2) {
                        $query2->select('id', 'name');
                    }]);
            }])
            ->with('orders')
            ->find($id, ['id', 'leader_worker_id', 'kind_work', 'status']);

        return $privateteam;
    }
}
