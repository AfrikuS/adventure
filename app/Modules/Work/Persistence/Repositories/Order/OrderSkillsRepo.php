<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\OrderSkill;
use App\Modules\Work\Persistence\Dao\Order\OrderSkillsDao;

class OrderSkillsRepo
{
    /** @var OrderSkillsDao */
    private $skillsDao;
    
    public function __construct(OrderSkillsDao $skillsDao)
    {
        $this->skillsDao = $skillsDao;
    }

    public function createOrderSkill($order_id, $domain_id, $need, $stock = 0)
    {
        $this->skillsDao->create(
            $order_id,
            $domain_id,
            $need,
            $stock
        );
    }

    public function findBy($order_id)
    {
        $skill = EntityStore::get(OrderSkill::class, 'order:'.$order_id);

        if ($skill != null) {

            return $skill;
        }

        $skillData = $this->skillsDao->findBy($order_id);

        $skill = new OrderSkill($skillData);

        EntityStore::add($skill, 'order:'.$order_id);

        return $skill;
    }

    public function update(OrderSkill $skill)
    {
        $this->skillsDao->update(
            $skill->id, 
            $skill->stockTimes
        );
    }

    public function deleteByOrder($order_id)
    {
        $this->skillsDao->deleteByOrder($order_id);
    }
}
