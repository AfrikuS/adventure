<?php

namespace App\Modules\Work\Domain\Handlers\Order\Builder;

use App\Modules\Work\Domain\Commands\Order\Builder\CreateOrderData;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class CreateOrderDataHandler
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function handle(CreateOrderData $command)
    {
        return $this->orderRepo->create(
            $command->desc,
            $command->domainCode,
            $command->price,
            $command->customer_id
        );
    }
}
