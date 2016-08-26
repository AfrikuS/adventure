<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class DeleteOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function deleteOrder($order_id)
    {
        $orderService = new OrderService($this->orderRepo);

        \DB::beginTransaction();
        try {

            $orderService->deleteWithMaterialsAndSkills($order_id);

        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

}
