<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Employment\Domain\Services\Lore\LearnLoreService;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Domain\Services\Order\WorkerOrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Finite\Exception\StateException;

class ApplySkill
{
    /** @var OrderRepo  */
    private $orderRepo;

    /** @var WorkerRepo */
    private $workerRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
        $this->workerRepo = app('WorkerRepo');
    }

    // process order,   work iteration,   approach - подход,попытки
    public function applySkill($order_id, $worker_id)
    {

        $this->validateCommand($order_id);
//        $order = $this->orderRepo->find($order_id);


//        $upBuildingLevelCmd = new UpBuildingLevelCmd();
//
//        $upBuildingLevelCmd->upBuildingLevel($order->customer_hero_id, $order->desc);


        $orderService = new OrderService($this->orderRepo);

        $workerOrderService = app('WorkerOrderService');

        $loreService = new LearnLoreService();

//        $lore_id = 1; // from order

        \DB::beginTransaction();
        try {






            $isCompletedStockSkills = $orderService->stockSkill($order_id, $worker_id);


            $loreService->attemptLearnInOrderWork($order_id, $worker_id);


            if ($isCompletedStockSkills) {

                $orderService->completeWork($order_id);

                $workerOrderService->takeReward($order_id, $worker_id);
            }


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateCommand($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        if ($order->status != Order::STATUS_STOCK_SKILLS) {

            throw new StateException;
        }
    }
}
