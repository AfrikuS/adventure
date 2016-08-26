<?php

namespace App\Commands\Work\Team\Leader;

use App\Commands\Work\Team\UpdateTeamPiesCommand;
use App\Entities\Work\Team\TeamWorker;
use App\Exceptions\WorkerBelongTeamException;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\WorkerRepositoryObj;

class AcceptJoinOfferCommand
{
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var  PrivateTeamRepository */
    private $teamRepo;

    public function __construct(WorkerRepositoryObj $workerRepo, PrivateTeamRepository $teamRepo)
    {
        $this->workerRepo = $workerRepo;
        $this->teamRepo = $teamRepo;
    }

    public function acceptWorkerToTeam($offer_id)
    {
        $joinOffer = $this->teamRepo->getOfferJoinById($offer_id);
        /** @var  TeamWorker */
        $candidate = $this->workerRepo->getTeamWorkerSimpleById($joinOffer->worker_id);

        if ($candidate->team_id !== null) {

            throw new WorkerBelongTeamException;
        }

        \DB::beginTransaction();
        try {


            $candidate->joinToTeam($joinOffer->team_id);
            $joinOffer->delete();
            
            $cmd = new UpdateTeamPiesCommand($this->teamRepo);
            $cmd->updateTeamPies($candidate->team_id);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }

        \DB::commit();
    }
}
