<?php

namespace App\Commands\Work\TeamOrder;

use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Models\Work\Worker;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Entities\Work\TeamOrderEntity;

class AcceptTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo, WorkerRepositoryObj $workerRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
        $this->workerRepo = $workerRepo;
    }
    
    public function acceptTeamOrder($order_id, $worker_id)
    {
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithTeamById($worker_id);
        /** @var TeamOrderEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);


        if ($worker->team_id === null) {
            throw new WorkerWithoutTeamException;
        }

        if ($worker->team->leader_worker_id != $worker->id) {
            throw new NotTeamLeaderException;
        }


        \DB::beginTransaction();
        try {

            $teamOrderEntity->accept($worker);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

    }
}
