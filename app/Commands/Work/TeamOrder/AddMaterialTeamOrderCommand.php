<?php

namespace App\Commands\Work\TeamOrder;

use App\Exceptions\NotEnoughMaterialException;
use App\Models\Work\Worker;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Services\Transfers\OrderMaterialTransfer;
use App\Services\Transfers\TransferExecutor;
use App\Entities\Work\TeamOrderEntity;

class AddMaterialTeamOrderCommand
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

    public function addMaterial($order_id, $worker_id, $materialCode)
    {
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithTeamById($worker_id);
        /** @var TeamOrderEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);
        
        $orderMaterial = $teamOrderEntity->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);

        $needAmount = $orderMaterial->need - $orderMaterial->stock;
        
        if ($needAmount > $workerMaterial->value) {
            throw new NotEnoughMaterialException;
        };

        $transfer = new OrderMaterialTransfer($teamOrderEntity, $worker, $materialCode, $needAmount);

        \DB::beginTransaction();
        try {
            $this->transferExecutor->executeTransfer($transfer);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        $teamOrderEntity->checkStockMaterials();

        \DB::commit();
    }
}
