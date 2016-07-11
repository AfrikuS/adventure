<?php

namespace App\Repositories\Work;

use App\Models\Auth\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamJoinOffer;
use App\Models\Work\Worker;
use Illuminate\Support\Collection;
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

    public function findTeamWithPartnersById($id): PrivateTeam
    {
        $privateteam = PrivateTeam::
            with(['partners' => function ($query) {
                $query->select('id', 'team_id');
            }])
            ->find($id, ['id', 'leader_worker_id']);

        return $privateteam;
    }


//    /** @deprecated  */ // todo review
//    public static function getWorkersByTeam(PrivateTeam $team)
//    {
//        $workers = Worker::
//            select('id',  'status', 'privateteam_id', 'worker_user_id')
//            ->where('privateteam_id', $team->id)
//            ->with(['user' => function ($query) {
//                $query->select('id', 'name');
//            }])
//            ->get();
//
//        return $workers;
//    }

// todo extract to command
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


    public function getJoinOffersByTeamId($team_id)
    {
        return TeamJoinOffer::with(['user' => function($query) {
            $query->select('id', 'name');
        }])
        ->where('team_id', $team_id)
        ->get();
    }
    
    public function getOfferJoinById($offer_id)
    {
        return TeamJoinOffer::find($offer_id);
    }

}
