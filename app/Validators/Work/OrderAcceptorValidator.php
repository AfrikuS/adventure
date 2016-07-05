<?php

namespace App\Validators\Work;

use App\Models\Work\Order;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\Team\WorkerRepository;
use App\StateMachines\Work\OrderStateMachine;

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
        /** @var OrderStateMachine $order */
        $order = $this->orderRepository->findSimpleOrderById($order_id);

        if ($order->haveAcceptor() && ($order->acceptor_user_id == $user_id)) {
            return true;
        }
        
        return false;
    }
}
