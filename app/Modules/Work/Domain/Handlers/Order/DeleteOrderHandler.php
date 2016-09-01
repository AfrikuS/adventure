<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\DeleteOrder;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;

class DeleteOrderHandler
{
    /** @var OrdersRepo */
    private $orderRepo;
    
    /** @var OrderMaterialsRepo */
    private $materialsRepo;

    /** @var OrderSkillsRepo */
    private $skillsRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrdersRepo');
        $this->materialsRepo = app('OrderMaterialsRepo');
        $this->skillsRepo = app('OrderSkillsRepo');
    }
    
    public function handle(DeleteOrder $command)
    {
        $this->materialsRepo->deleteByOrder($command->order_id);
        $this->skillsRepo->deleteByOrder($command->order_id);


        $this->orderRepo->deleteOrder($command->order_id);
    }
}
