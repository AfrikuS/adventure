<?php

namespace App\Commands\Work\Team\Leader;

use App\Entities\Work\Team\TeamWorker;
use App\Repositories\Work\PrivateTeamRepository;

class RefuseJoinOfferCommand
{
//    /** @var  WorkerRepositoryObj */
//    private $workerRepo;
    /** @var  PrivateTeamRepository */
    private $teamRepo;

    public function __construct(PrivateTeamRepository $teamRepo)
    {
//        $this->workerRepo = $workerRepo;
        $this->teamRepo = $teamRepo;
    }

    public function refuseJoinOffer($offer_id)
    {
        $joinOffer = $this->teamRepo->getOfferJoinById($offer_id);
        /** @var  TeamWorker */
//        $candidate = $this->workerRepo->getTeamWorkerSimpleById($joinOffer->worker->id);

//        if ($candidate->team_id !== null) {
//
//            throw new WorkerBelongTeamException;
//        }
        
        \DB::beginTransaction();
        try {


//            $candidate->leftTeam();

            $joinOffer->delete();
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }

        \DB::commit();

    }            
}
