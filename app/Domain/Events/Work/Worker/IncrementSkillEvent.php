<?php

namespace App\Domain\Events\Work\Worker;

use App\Persistence\Models\Work\Worker\WorkerSkill;
use App\Persistence\Repositories\Work\Worker\WorkerSkillsRepo;

class IncrementSkillEvent
{
    public function handle($worker_id, $code, $amount)
    {
        $skillRepo = new WorkerSkillsRepo();
        
        /** @var WorkerSkill $skill */
        $skill = $skillRepo->findBy($worker_id, $code);
        
        
        $skill->increment($amount);
        
        
        $skillRepo->update($skill);
    }
}
