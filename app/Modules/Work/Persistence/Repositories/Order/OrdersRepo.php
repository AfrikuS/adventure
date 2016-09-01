<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Order\OrderMaterial;
use App\Modules\Work\Persistence\Dao\Order\OrdersDao;

class OrdersRepo
{
    /** @var OrdersDao */
    private $ordersDao;

    /** @var OrderMaterialsRepo */
    private $materialsRepo;

    /** @var OrderSkillsRepo */
    private $skillsRepo;

    public function __construct(OrdersDao $ordersDao,
                                OrderMaterialsRepo $materialsRepo,
                                OrderSkillsRepo $skillsRepo
    )
    {
        $this->materialsRepo = $materialsRepo;
        $this->ordersDao = $ordersDao;
        $this->skillsRepo = $skillsRepo;
    }

    public function create($desc, $domain_id, $price, $customer_id)
    {
        return
            $this->ordersDao->create(
                $desc,
                $domain_id,
                $price,
                $customer_id,

                Order::STATUS_FREE,
                Order::TYPE_INDIVIDUAL
            );
    }

    public function findOrderWithMaterialsById($order_id)
    {
        $order = $this->find($order_id);
        
        $materials = $this->materialsRepo->getMaterialsCollection($order_id);
        
        $order->setMaterials($materials);
        
        return $order;
    }

    public function findOrderWithSkill($order_id)
    {
        /** @var Order $order */
        $order = $this->find($order_id);

        $skill = $this->skillsRepo->findBy($order_id);
        
        $order->setSkill($skill);
        
        return $order;
    }

    public function find($order_id)
    {
        $order = EntityStore::get(Order::class, $order_id);

        if ($order != null) {

            return $order;
        }


        $orderData = $this->ordersDao->find($order_id);

        $order = new Order($orderData);


        EntityStore::add($order, $order->id);

        return $order;
    }
    
    public function deleteOrder($order_id)
    {
        $this->ordersDao->delete($order_id);
    }

    public function updateMaterialAmount(OrderMaterial $material)
    {
        $this->materialsRepo->updateStockAmount($material);
    }

    public function updateStatus(Order $order)
    {
        $this->ordersDao->update(
            $order->id,
            $order->status,
            $order->acceptor_worker_id
        );
    }

    public function getAcceptedOrders($worker_id)
    {
        return $this->ordersDao->getAcceptedOrders($worker_id);
    }

    public function getFreeOrders()
    {
        $ordersArr = $this->ordersDao->getFreeOrders();
        
        return $ordersArr;
    }
}
