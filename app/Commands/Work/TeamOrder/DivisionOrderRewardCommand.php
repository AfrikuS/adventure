<?php

namespace App\Commands\Work\TeamOrder;

use App\Models\Core\Hero;
use App\Models\Work\Team\TeamRewardPie;
use App\Repositories\HeroRepositoryObj;

class DivisionOrderRewardCommand
{
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(HeroRepositoryObj $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function divideOrderReward($team_id, $rewardTotal)
    {
        $rewardPies = TeamRewardPie::where('team_id', $team_id)->get();


        \DB::beginTransaction();
        try {

            /** @var TeamRewardPie $pie */
            foreach ($rewardPies as $pie) {
                $piePercent = (int) $pie->amount_percent / 100;
                $rewardPieValue = $rewardTotal * $piePercent;

//                $heroRepo = ; //new HeroRepositoryObj(); //
//                $worker_id = ;
                $hero = $this->heroRepo->findById($pie->worker_id);
                $this->heroRepo->incrementGold($hero, $rewardPieValue);
            }

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
        \DB::commit();
    }
}
