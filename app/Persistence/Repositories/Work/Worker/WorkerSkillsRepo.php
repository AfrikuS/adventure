<?php

namespace App\Persistence\Repositories\Work\Worker;

use App\Persistence\Dao\Work\Worker\WorkerSkillsDao;
use App\Persistence\Models\Work\Worker\WorkerSkill;

class WorkerSkillsRepo
{
    /** @var WorkerSkillsDao */
    private $skillsDao;

    public function __construct()
    {
        $this->skillsDao = new WorkerSkillsDao();
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
