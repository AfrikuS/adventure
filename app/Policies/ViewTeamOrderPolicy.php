<?php

namespace App\Policies;

use App\Models\Work\Worker;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Entities\Work\TeamOrderEntity;

class ViewTeamOrderPolicy
{
    public function check($user, Worker $worker, TeamOrderEntity $teamOrder)
    {
        $a = $worker->id;
        $b = $teamOrder->acceptor_worker_id;
        
        return $a == $b; 
    }
}
