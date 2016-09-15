<?php

namespace App\Modules\Work\Persistence\Repositories\Team;

use App\Modules\Work\Persistence\Dao\Team\Economy\RewardPieDao;
use App\Modules\Work\Persistence\Dao\Team\JoinOffersDao;
use App\Modules\Work\Persistence\Dao\Team\TeamDao;

class TeamRepo
{
    /** @var TeamDao */
    private $teams;
    
    /** @var JoinOffersDao */
    private $offers;
    
    /** @var RewardPieDao */
    private $rewardPies;

    public function __construct(TeamDao $teams, JoinOffersDao $offers, RewardPieDao $rewardPies)
    {
        $this->teams = $teams;
        $this->offers = $offers;
        $this->rewardPies = $rewardPies;
    }

    public function getAll()
    {
        $teamsData = $this->teams->get();
        
        return $teamsData;
    }

    public function find($team_id)
    {
        $teamData = $this->teams->find($team_id);
        
        return $teamData;
    }

    public function getJoinOffersByTeamId($team_id)
    {
        $offersData = $this->offers->getByTeamId($team_id);
        
        return $offersData;
    }

    public function getRewardPies($team_id)
    {
        $piesData = $this->rewardPies->getByTeam($team_id);
        
        return $piesData;
    }

    public function getPartners($team_id)
    {
        $partnersData = $this->teams->getPartners($team_id);
        
        return $partnersData;
    }

}
