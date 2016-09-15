<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\StockSkill;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;

class StockSkillHandler
{
    /** @var OrderSkillsRepo */
    private $skillsRepo;

    public function __construct(OrderSkillsRepo $skillsRepo)
    {
        $this->skillsRepo = $skillsRepo;
    }

    public function handle(StockSkill $command)
    {
        $skill = $this->skillsRepo->findBy($command->order_id);

        $skill->stock();

        
        $this->skillsRepo->update($skill);
    }
}
