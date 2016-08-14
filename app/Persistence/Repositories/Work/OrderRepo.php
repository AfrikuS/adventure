<?php

namespace App\Persistence\Repositories\Work;

use App\Infrastructure\IdentityMap;
use App\Persistence\Dao\Work\OrderMaterialsDao;
use App\Persistence\Dao\Work\OrderDao;
use App\Persistence\Models\Work\Order;
use App\Persistence\Models\Work\Order\Material;
use App\Persistence\Models\Work\Order\Materials;
use App\Persistence\Models\Work\Order\OrderMaterial;
use App\Persistence\Models\Work\Order\StockDataDto;
use App\Persistence\Services\Work\Order\OrderDataDto;

class OrderRepo
{
    /** @var IdentityMap */
    private $identityMap;

    /** @var OrderMaterialsDao */
    private $materialsDao;

    /** @var OrderDao */
    private $orderDao;

    public function __construct()
    {
        $this->materialsDao = new OrderMaterialsDao();
        $this->orderDao = new OrderDao();

        $this->identityMap = IdentityMap::getInstance();
    }

    public function findOrderWithMaterialsById($order_id)
    {
        $orderModel = $this->orderDao->findById($order_id);
        
        $materials = $this->materialsDao->getAllByOrderId($order_id);

        $materialsMap = [];

        foreach ($materials as $material) {

            $code = $material->code;
            $materialsMap[$code] = $this->buildMaterial($material);
        }

        $materials = new Materials($materialsMap, null);


        $orderModel->materials = $materials;



        return new Order($orderModel);
    }

    public function findMaterialBy($order_id, $code)
    {
        $materialData = $this->materialsDao->findBy($order_id, $code);
        
        if (null == $materialData) {
        
            return null;
        }
        
        return new OrderMaterial($materialData);
    }

    public function getStockMaterialsData($order_id)
    {
        $needAmount = $this->materialsDao->getSummarizeNeed($order_id);
        
        $stockAmount = $this->materialsDao->getSummarizeStocked($order_id);

        return new StockDataDto($needAmount, $stockAmount);
    }

    private function buildMaterial(\stdClass $materialDao)
    {
        return new Material($materialDao->code, $materialDao->need, $materialDao->stock);
    }

    public function find($order_id)
    {
        $order = $this->identityMap->getObject(Order::class, $order_id);
        
        if ($order != null) {
            
            return $order;
        }
        
        
        $orderData = $this->orderDao->findById($order_id);

        $order = $this->orderMapper($orderData);
        
        
        $this->identityMap->addObject($order, $order->id);
        
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
        $materials = $this->materialsDao->getAllByOrderId($order->id);

        $materialsMap = [];

        foreach ($materials as $material) {
            $code = $material->code;
            $materialsMap[$code] = $material;
        }

        $materials = new Materials($materialsMap, null);
        $order->materials = $materials;

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

    public function create(OrderDataDto $orderData)
    {
        return
            $this->orderDao->create(
                $orderData->desc,
                $orderData->skillCode,
                $orderData->price,
                $orderData->customer_id
            );
    }

    private function orderMapper($orderData)
    {
        $order = new Order($orderData);

        return $order;
    }
}
