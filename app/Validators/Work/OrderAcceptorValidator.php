<?php

namespace App\Validators\Work;

use App\Models\Work\Order;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\Team\WorkerRepository;
use App\Entities\Work\OrderEntity;

class OrderAcceptorValidator
{
    /** @var  OrderRepositoryObj */
    private $orderRepository;

    public function __construct(OrderRepositoryObj $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function isOrderAcceptor($user_id, $order_id): bool
    {
        /** @var OrderEntity $order */
        $order = $this->orderRepository->findSimpleOrderById($order_id);

        if ($order->haveAcceptor() && ($order->acceptor_worker_id == $user_id)) {
            return true;
        }
        
        return false;
    }
}
