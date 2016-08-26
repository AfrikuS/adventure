<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Work\Domain\Entities\Worker\WorkerSkill;
use App\Modules\Work\Persistence\Dao\Worker\WorkerSkillsDao;

class WorkerSkillsRepo
{
    /** @var WorkerSkillsDao */
    private $skillsDao;

    public function __construct(WorkerSkillsDao $skillsDao)
    {
        $this->skillsDao = $skillsDao;
    }

    public function findBy($worker_id, $code)
    {
        $skillData = $this->skillsDao->find($worker_id, $code);
        
        if (null == $skillData) {
            return null;
        }
        
        return new WorkerSkill($skillData);
    }

    public function getSkills($worker_id)
    {
        $skillsArr = $this->skillsDao->getAll($worker_id);
        
        return $skillsArr;
    }

    public function update($skill)
    {
        $this->skillsDao->update($skill);
    }
}
