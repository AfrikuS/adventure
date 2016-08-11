<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\MaterialsDao;
use App\Persistence\Dao\Work\OrderDao;
use App\Persistence\Models\Work\Order;

class OrderRepo
{
    /** @var MaterialsDao */
    private $materialsDao;

    /** @var OrderDao */
    private $orderDao;

    public function __construct()
    {
        $this->materialsDao = new MaterialsDao();
        $this->orderDao = new OrderDao();
    }

    public function findOrderWithMaterialsById($order_id)
    {
        $orderModel = $this->orderDao->findById($order_id);
        
        $materials = $this->materialsDao->getOrderMaterialsById($order_id);

        $orderModel->materials = $materials;
        
        
        return new Order($orderModel);
    }

    public function findSimpleOrder($order_id)
    {
        $orderModel = $this->orderDao->findById($order_id);

        return new Order($orderModel);
    }
    

    public function deleteOrder($order_id)
    {
        $materials_ids = $this->getMaterialsIds($order_id);

        \DB::table('work_order_materials')
            ->whereIn('id', $materials_ids)
            ->delete();

        \DB::table('work_orders')
            ->where('id', $order_id)
            ->delete();
    }

    public function updateMaterialAmount(Order $order, $materialCode)
    {
        $material = $order->findMaterialByCode($materialCode);
        
        $this->materialsDao->save($material);
        
    }

    private function getMaterialsIds($order_id)
    {
        $ids = \DB::table('work_order_materials')
            ->select(['id'])
            ->where('order_id', $order_id)
            ->get();

        $idsArr = array_map(function($item) {
            return $item->id;
        }, $ids);

        return $idsArr;
    }
}
