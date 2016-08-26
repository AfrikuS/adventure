<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\StockSkill;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;

class StockSkillHandler
{
    /** @var OrderSkillsRepo */
    private $skills;

    public function __construct(OrderSkillsRepo $skills)
    {
        $this->skills = $skills;
    }

    public function handle(StockSkill $command)
    {
        $skill = $this->skills->findSingleByOrder($command->order_id);

        $skill->stock();

        $this->skills->update($skill);
    }
}
