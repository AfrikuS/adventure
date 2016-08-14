<?php

namespace App\Domain\Events\Work\Order\Builder;

use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Services\Work\Order\OrderDataDto;

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
