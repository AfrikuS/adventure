<?php

namespace App\Persistence\Services\Work\Order;

use App\Persistence\Repositories\Work\OrderRepo;

class CreateOrderDataEvent
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function handle(OrderDataDto $orderDataDto)
    {
        return $this->orderRepo->create($orderDataDto);
    }
}
