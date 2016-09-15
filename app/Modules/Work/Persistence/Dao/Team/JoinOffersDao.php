<?php

namespace App\Modules\Work\Persistence\Dao\Team;

class JoinOffersDao
{
    private $table = 'work_team_joinoffers';

//    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
//    `worker_id` INT UNSIGNED NOT NULL,
//    `team_id` INT UNSIGNED NOT NULL,

    public function getByTeamId($team_id)
    {
        $offersData = \DB::table($this->table . ' AS jo')
            ->select(['jo.id', 'jo.worker_id', 'jo.team_id', 'u.name'])
            ->join('users AS u', 'jo.worker_id', '=', 'u.id')
            ->where('team_id', $team_id)
            ->get();

        return $offersData;


//        return TeamJoinOffer::with(['user' => function($query) {
//            $query->select('id', 'name');
//        }])
//            ->where('team_id', $team_id)
//            ->get();

    }
}
