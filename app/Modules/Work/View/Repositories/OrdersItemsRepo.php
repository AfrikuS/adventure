<?php

namespace App\Modules\Work\View\Repositories;

use App\Modules\Employment\Persistence\Dao\DomainsDao;
use App\Modules\Work\Persistence\Dao\Order\OrdersDao;
use App\Modules\Work\View\DataObjects\OrderItem;

class OrdersItemsRepo
{
    /** @var OrdersDao */
    private $ordersDao;
    
    public function __construct(OrdersDao $ordersDao)
    {
        $this->ordersDao = $ordersDao;
    }

    public function getAcceptedBy($worker_id)
    {
        $orderItemsData = $this->ordersDao->getAcceptedOrders($worker_id);
        
        $orderItems = [];

        foreach ($orderItemsData as $orderItemData) {
            
            $orderItem = new OrderItem($orderItemData);
            
            $orderItems[] = $orderItem;
        }
        
        return $orderItems;
    }

    public function getFreeOrders()
    {
        $orderItemsData = $this->ordersDao->getFreeOrders();

        $orderItems = [];

        foreach ($orderItemsData as $orderItemData) {

            $orderItem = new OrderItem($orderItemData);

            $orderItems[] = $orderItem;
        }

        return $orderItems;
    }
}
