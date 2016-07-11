<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Repositories\Work\OrderRepositoryObj;

class DeleteOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function deleteOrder($order_id)
    {
        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);

        \DB::beginTransaction();
        try {

            $material_ids = $order->materials->map(function ($material, $key) {
                return $material->id;
            })->toArray();

            OrderMaterials::destroy($material_ids);


            Order::destroy($order_id);
        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

}
