<?php

namespace App\Commands\Work\Order\Actions;

use App\Domain\Services\Work\Order\OrderService;
use App\Persistence\Repositories\Work\OrderRepo;

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
