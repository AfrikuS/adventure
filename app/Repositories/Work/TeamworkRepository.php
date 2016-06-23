<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamWorker;
use App\Models\Work\Team\TeamworkOffer;

/** @deprecated  */
class TeamworkRepository
{
    public static function createTeamworkOffer(User $leader, $usersCount, $kindWork = 'mine_white_balls')
    {
        $offer = TeamworkOffer::build([
            'leader_user_id' => $leader->id,
            'users_count' => $usersCount,
            'kind_work' => $kindWork,
        ]);
        
        return $offer;
    }



    public static function createTeamWorker(User $user, PrivateTeam $team)
    {
        $worker = TeamWorker::build([
            'worker_user_id' => $user->id,
            'privateteam_id' => $team->id,
            'status' => 'inactive',
        ]);
        
        return $worker;
    }

    public static function getWorkersByTeam(PrivateTeam $team)
    {
        $workers = TeamWorker::
            select('id',  'status', 'privateteam_id', 'worker_user_id')
            ->where('privateteam_id', $team->id)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();

        return $workers;
    }

    public static function changeWorkerStatusAfterWork(PrivateTeam $team, $workerStatus)
    {
        TeamWorker::where('privateteam_id', '=', $team->id)->update(['status' => $workerStatus]);

//        $workers->each(function($worker) {
//            $worker->status = 'inactive';
//            $worker->save();
//        });

//        $values=array('column1'=>'value','column2'=>'value2');
//        ItemTable::whereIn('primary_key','value')->update($values);
//        Note: whereIn() is used for arrays..
    }
}
