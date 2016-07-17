<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Worker;
use App\Repositories\Work\OrderRepositoryObj;

class AcceptOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function accept($order_id, Worker $worker)
    {
        $orderEntity = $this->orderRepo->findSimpleOrderById($order_id);

        $orderEntity->accept($worker->id);

    }
}
