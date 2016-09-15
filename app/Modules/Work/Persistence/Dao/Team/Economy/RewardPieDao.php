<?php

namespace App\Modules\Work\Persistence\Dao\Team\Economy;

class RewardPieDao
{
    private $table = 'work_team_reward_pies';
    
    public function getByTeam($team_id)
    {
        $teamsData = \DB::table($this->table)
            ->select(['id', 'worker_id', 'team_id', 'amount_percent'])
            ->where('team_id', $team_id)
            ->get();

        return $teamsData;
    }
}
