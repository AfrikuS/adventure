<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Repositories\Work\OrderRepositoryObj;

class DeleteOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepo;
    }

    public function deleteOrder($order_id)
    {

        \DB::beginTransaction();
        try {


            $this->orderRepo->deleteOrder($order_id);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

}
