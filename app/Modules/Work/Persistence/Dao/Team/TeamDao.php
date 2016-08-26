<?php

namespace App\Modules\Work\Persistence\Dao\Team;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class TeamDao
{
    private $table = 'work_teams';
/*`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`leader_worker_id` INT UNSIGNED NOT NULL,
`status` VARCHAR(255) NOT NULL,*/

    public function create($leader_id, $status)
    {
        \DB::table($this->table)
            ->insertGetId([
                'leader_worker_id' => $leader_id,
                'status' => $status,
            ]);
    }

    public function find($id)
    {
        $teamData = \DB::table($this->table)
            ->select(['id', 'leader_worker_id', 'status'])
            ->find($id);

        if (null === $teamData) {

            throw new EntityNotFound_Exception;
        }

        return $teamData;

    }

    public function get()
    {
        $teamsData = \DB::table($this->table)
            ->select(['id', 'leader_worker_id', 'status'])
            ->get();

        return $teamsData;
    }

    public function getPartners($team_id)
    {
        $workersTable = 'work_workers';
        $usersTable = 'users';

        $offersData = \DB::table($workersTable . ' AS w')
            ->select(['u.id', 'u.name'])
            ->join($usersTable . ' AS u', 'w.id', '=', 'u.id')
            ->where('w.team_id', $team_id)
            ->get();

        return $offersData;
    }
}
