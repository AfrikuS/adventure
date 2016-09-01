<?php

namespace test\Models;

use App\Modules\Work\Domain\Entities\Order\Order;
use TestCase;

class OrderStatusesTest extends TestCase
{
    public function testBasicExample()
    {

        $orderData = new \stdClass();
        $orderData->id = 1;
        $orderData->status = Order::STATUS_FREE;
        $orderData->desc = 'desc';
        $orderData->type = Order::TYPE_INDIVIDUAL;
        $orderData->domain_id = 2;
        $orderData->price = 200;
        $orderData->acceptor_worker_id = 8;
        $orderData->customer_hero_id = 8;

        $order = new Order($orderData);

//        $this->assertEquals($order->id, 2);
        
//        $mockOrder = $this->getMock(Order::class, [], [$orderData]);
        $this->assertEquals($order->status, Order::STATUS_FREE);

        $order->setStatusAccepted();

        $this->assertEquals($order->status, Order::STATUS_ACCEPTED);

        $order->setStatusEstimated();
        $this->assertEquals($order->status, Order::STATUS_STOCK_MATERIALS);

    }

}
