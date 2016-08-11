<?php

namespace App\Commands\Work\Order\Actions;

use App\Commands\Hero\UpBuildingLevelCmd;
use App\Commands\Work\IndividualOrder\TakeRewardCommand;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;

class ApplySkill
{
    /** @var OrderRepositoryObj  */
    private $orderRepo;

    /** @var WorkerRepositoryObj  */
    private $workerRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepositoryObj();
        $this->workerRepo = new WorkerRepositoryObj();
    }

    public function applySkill($order_id, $worker_id)
    {
        $order = $this->orderRepo->findSimpleOrderById($order_id);



        $takeRewardCmd = new TakeRewardCommand($this->orderRepo, $this->workerRepo, new HeroRepositoryObj());

        $takeRewardCmd->takeReward($order_id, $worker_id);

        
        $upBuildingLevelCmd = new UpBuildingLevelCmd();

        $upBuildingLevelCmd->upBuildingLevel($order->customer_hero_id, $order->desc);
    }
}
