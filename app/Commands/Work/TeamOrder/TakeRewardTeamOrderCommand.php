<?php

namespace App\Commands\Work\TeamOrder;

use App\Exceptions\OrderNotCompletedException;
use App\Models\Core\Hero;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Entities\Work\TeamOrderEntity;

class TakeRewardTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo, WorkerRepositoryObj $workerRepo, HeroRepositoryObj $heroRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
        $this->workerRepo = $workerRepo;
        $this->heroRepo = $heroRepo;
    }

    public function takeReward($order_id, $worker_id)
    {
        /** @var TeamOrderEntity */
        $order =  $this->teamOrderRepo->findSimpleOrderById($order_id);
        
//        /** @var Hero $hero */
//        $hero = $this->heroRepo->findById($worker_id);

        
        if (!$order->isCompleted()) {
            throw new OrderNotCompletedException();
        }
        
        \DB::beginTransaction();
        try {

//            $this->heroRepo->incrementGold($hero, $order->price);
            $cmd = new DivisionOrderRewardCommand($this->heroRepo);
            $cmd->divideOrderReward($order->acceptor_team_id, $order->price);

            $cmd = new DeleteTeamOrderCommand($this->teamOrderRepo);
            $cmd->deleteTeamOrder($order_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
        \DB::commit();
    }
}
