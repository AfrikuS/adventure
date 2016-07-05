<?php

namespace App\Commands\Work\TeamOrder;

use App\Models\Work\Worker;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Services\Transfers\TeamOrder\TeamOrderApplySkillTransfer;
use App\Services\Transfers\TransferExecutor;
use App\StateMachines\Work\TeamOrderEntity;

class ApplySkillTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var TransferExecutor  */
    private $transferExecutor;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo, WorkerRepositoryObj $workerRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
        $this->workerRepo = $workerRepo;
        $this->transferExecutor = new TransferExecutor();
    }

    public function applySkill($order_id, $worker_id, $skillCode)
    {
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithTeamById($worker_id);

        /** @var TeamOrderEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);



        $transfer = new TeamOrderApplySkillTransfer($teamOrderEntity, $worker, $skillCode, 1);

        \DB::beginTransaction();
        try {

            $this->transferExecutor->executeTransfer($transfer);

            $this->workerRepo->upSkillByCode($worker, $skillCode, 3);

            $teamOrderEntity->checkFinishStockSkills();
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

}
