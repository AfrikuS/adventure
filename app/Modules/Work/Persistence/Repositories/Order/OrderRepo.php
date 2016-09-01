<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Order\OrderMaterial;
use App\Modules\Work\Persistence\Dao\Order\OrdersDao;
use App\Modules\Work\Persistence\Dao\Order\OrderMaterialsDao;
use App\Persistence\Models\Work\Order\StockDataDto;

class OrderRepo
{
    /** @var OrderMaterialsDao */
    private $materialsDao;

    /** @var OrdersDao */
    private $orderDao;

    public function __construct()
    {
        $this->materialsDao = app('OrderMaterialsDao');
        $this->orderDao = app('OrderDao');
    }

    public function findOrderWithMaterialsById($order_id)
    {
        $orderData = $this->orderDao->findById($order_id);
        
        $materialsData = $this->materialsDao->getByOrder($order_id);

        $materialsMap = [];

        foreach ($materialsData as $materialData) {

            $code = $materialData->code;
            $materialsMap[$code] = new OrderMaterial($materialData);
        }

//        $materials = new Materials($materialsMap, null);

        $order = new Order($orderData);

        $order->setMaterials($materialsMap);

        
        return $order;
    }

    public function findMaterialBy($order_id, $code)
    {
        $material = EntityStore::get(OrderMaterial::class, $order_id . $code);
//        $material = $this->identityMap->getObject(OrderMaterial::class, $order_id . $code);

        if ($material != null) {

            return $material;
        }

        $materialData = $this->materialsDao->findBy($order_id, $code);

        if (null == $materialData) {

            return null;
        }

        $material = new OrderMaterial($materialData);

        EntityStore::add($material, $order_id . $code);

        return $material;
    }

    public function getStockMaterialsData($order_id)
    {
        $needAmount = $this->materialsDao->getSummarizeNeed($order_id);
        
        $stockAmount = $this->materialsDao->getSummarizeStocked($order_id);

        return new StockDataDto($needAmount, $stockAmount);
    }

    private function buildMaterial(\stdClass $materialData)
    {
        return 
            new OrderMaterial($materialData);
    }

    public function find($order_id)
    {
        $order = EntityStore::get(Order::class, $order_id);

        if ($order != null) {
            
            return $order;
        }
        
        
        $orderData = $this->orderDao->findById($order_id);

        $order = $this->orderMapper($orderData);


        EntityStore::add($order, $order->id);
        
        return $order;
    }
    

    public function deleteOrder($order_id)
    {
        $this->orderDao->delete($order_id);
    }

    public function updateMaterialAmount(Order $order, $materialCode)
    {
        $material = $order->materials->getByCode($materialCode);
        
        $this->materialsDao->save($material);
        
    }

    public function updateStatus($order)
    {
        $this->orderDao->save($order);
    }

    public function updateAcceptor($order)
    {
        $this->orderDao->save($order);
    }

    public function getWithMaterialsById($order_id)
    {
        $order = $this->orderDao->findById($order_id);
        $materialsData = $this->materialsDao->getByOrder($order->id);

        $materialsMap = [];

        foreach ($materialsData as $material) {
            $code = $material->code;
            $materialsMap[$code] = $material;
        }

//        $materials = new Materials($materialsMap, null);
        $order->setMaterials($materialsMap);

        return new Order($order);
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

    public function create($desc, $domain_id, $price, $customer_id)
    {
        return 
            $this->orderDao->create(
                $desc,
                $domain_id,
                $price,
                $customer_id
            );
    }

    private function orderMapper($orderData)
    {
        $order = new Order($orderData);

        return $order;
    }

    public function getAcceptedOrders($worker_id)
    {
        return $this->orderDao->getAcceptedOrders($worker_id);
    }

    public function getFreeOrders()
    {
        $ordersArr = $this->orderDao->getFreeOrders();
        
        return $ordersArr;
    }
}
