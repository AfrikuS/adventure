<?php

namespace App\Security;

use App\Entities\Work\TeamOrderEntity;
use App\Exceptions\WorkerWithoutTeamException;
use App\Models\Work\Worker;

class TeamOrderSecurity
{
    /** @var Worker */
    private $worker;

    public function __construct(Worker $worker)
    {
        $this->worker = $worker;
    }

    public function verifyViewTeamOrderList()
    {
        if ($this->worker->team_id === null) {
            
            throw new WorkerWithoutTeamException;
        }
    }

    public function canViewTeamOrder(TeamOrderEntity $order): bool
    {
        $orderAcceptor = $order->acceptor;
        
        $orderAcceptorTeam_id = $orderAcceptor->team_id;

        $workerTeam_id = $this->worker->team_id;
        
        return $workerTeam_id == $orderAcceptorTeam_id;
    }
}
