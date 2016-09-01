<?php

namespace App\Modules\Work\Domain\Handlers\Order\Builder;

use App\Modules\Work\Domain\Commands\Order\Builder\GenerateSkills;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;

class GenerateSkillsHandler
{
    /** @var OrderSkillsRepo */
    private $skillsRepo;
    
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct(OrdersRepo $ordersRepo, OrderSkillsRepo $skillsRepo)
    {
        $this->ordersRepo = $ordersRepo;
        $this->skillsRepo = $skillsRepo;
    }

    public function handle(GenerateSkills $command)
    {
        $order = $this->ordersRepo->find($command->order_id);

        $this->skillsRepo->createOrderSkill(
            $order->id,
            $order->domain_id,
            $command->needTimes
        );
    }
}
