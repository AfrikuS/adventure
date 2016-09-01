<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Employment\Domain\Services\Lore\LearnLoreService;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Domain\Services\Order\WorkerOrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Finite\Exception\StateException;

class ApplySkillAction
{
    /** @var OrdersRepo  */
    private $ordersRepo;

    /** @var WorkerRepo */
    private $workerRepo;

    public function __construct()
    {
        $this->ordersRepo = app('OrdersRepo');
        $this->workerRepo = app('WorkerRepo');
    }

    public function applySkill($order_id, $worker_id)
    {
        $this->validateAction($order_id);

        $orderService = new OrderService($this->ordersRepo);

        $loreService = new LearnLoreService();

        \DB::beginTransaction();
        try {






            $orderService->stockSkill($order_id, $worker_id);


            $loreService->attemptLearnInOrderWork($order_id, $worker_id);


            $orderService->checkOrderCompleted($order_id, $worker_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction($order_id)
    {
        $order = $this->ordersRepo->find($order_id);

        if ($order->status != Order::STATUS_STOCK_SKILLS) {

            throw new StateException;
        }
    }
}
