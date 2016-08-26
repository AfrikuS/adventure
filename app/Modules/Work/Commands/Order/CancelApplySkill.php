<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class CancelApplySkill
{
    /** @var OrderRepo  */
    private $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function cancel($order_id)
    {

        $orderService = new OrderService($this->orderRepo);


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
