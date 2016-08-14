<?php

namespace App\Commands\Work\Order\Actions;

use App\Domain\Services\Work\Order\OrderService;
use App\Domain\Services\Work\Worker\WorkerSkillsService;
use App\Domain\Services\Work\WorkerOrderService;
use App\Persistence\Models\StateControllers\OrderStateCtrl;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\Worker\WorkerSkillsRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use Finite\Exception\StateException;

class ApplySkill
{
    /** @var OrderRepo  */
    private $orderRepo;

    /** @var WorkerRepo */
    private $workerRepo;

    /** @var OrderStateCtrl */
    private $orderStateCtrl;

    public function __construct(OrderRepo $orderRepo, WorkerRepo $workerRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;

        $this->orderStateCtrl = new OrderStateCtrl();
    }

    // process order,   work iteration,   approach - подход,попытки
    public function applySkill($order_id, $worker_id)
    {
        $order = $this->orderRepo->find($order_id);

        OrderStateCtrl::validateApplySkill($order);



//        $upBuildingLevelCmd = new UpBuildingLevelCmd();
//
//        $upBuildingLevelCmd->upBuildingLevel($order->customer_hero_id, $order->desc);


        $workerOrderService = new WorkerOrderService(
            $this->orderRepo,
            $this->workerRepo
        );


        $orderService = new OrderService($this->orderRepo);


        

        \DB::beginTransaction();
        try {



            $workerOrderService->takeReward($order_id, $worker_id);


            $workerOrderService->workProcess($order_id, $worker_id);



            // callback
            // check finish
            $orderService->changeStatusAfterApplyingSkill($order_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

    }
}
