<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Services\Work\Order\OrderService;
use App\Repositories\Work\OrderRepositoryObj;

class DeleteOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function deleteOrder($order_id)
    {
        $orderService = new OrderService($this->orderRepo);

        \DB::beginTransaction();
        try {

            $orderService->deleteWithMaterials($order_id);

        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

}
