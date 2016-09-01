<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Infrastructure\IdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\OrderSkill;
use App\Modules\Work\Domain\Entities\Order\OrderSkills;
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

    /** @deprecated */
    public function getByOrder($order_id)
    {
        $skillsData = $this->skillsDao->getAllByOrderId($order_id);
        
        $skills = new OrderSkills($skillsData);
        
        return $skills;
    }
    
    /** @deprecated  */
    public function getCodesByOrderId($order_id)
    {
        $skills = $this->skillsDao->getAllByOrderId($order_id);

        $codesArr = array_map(function ($skill) {
            return $skill->code;
        }, $skills);

        return $codesArr;
    }

    public function findSingleByOrder($order_id)
    {
        $skill = EntityStore::get(OrderSkill::class, 'order:'.$order_id);

        if ($skill != null) {

            return $skill;
        }

        $skillData = $this->skillsDao->findSingle($order_id);

        $skill = new OrderSkill($skillData);

        EntityStore::add($skill, 'order:'.$order_id);

        return $skill;
    }

    public function update($skill)
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

    public function isFullStockSkills($order_id)
    {
        $needSum = $this->skillsDao->getSummarizeNeed($order_id);
        $stockSum = $this->skillsDao->getSummarizeStocked($order_id);
        
        return $needSum === $stockSum;
    }
}
