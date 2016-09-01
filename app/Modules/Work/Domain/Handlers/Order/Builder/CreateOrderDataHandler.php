<?php

namespace App\Modules\Work\Domain\Handlers\Order\Builder;

use App\Modules\Work\Domain\Commands\Order\Builder\CreateOrderData;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class CreateOrderDataHandler
{
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct(OrdersRepo $orderRepo)
    {
        $this->ordersRepo = $orderRepo;
    }

    public function handle(CreateOrderData $command)
    {
        return $this->ordersRepo->create(
            $command->desc,
            $command->domain_id,
            $command->price,
            $command->customer_id
        );
    }
}
