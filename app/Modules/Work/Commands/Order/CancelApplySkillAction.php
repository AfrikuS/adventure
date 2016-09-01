<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class CancelApplySkillAction
{
    /** @var OrdersRepo  */
    private $ordersRepo;

    public function __construct()
    {
        $this->ordersRepo = app('OrdersRepo');
    }

    public function cancel($order_id)
    {

        $orderService = new OrderService($this->ordersRepo);


        \DB::beginTransaction();
        try {



            $orderService->cancelStatusApplyingSkill($order_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

    }
}
