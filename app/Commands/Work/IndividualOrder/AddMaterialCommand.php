<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Worker;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Services\Transfers\OrderMaterialTransfer;
use App\Services\Transfers\TransferExecutor;
use App\Entities\Work\OrderEntity;

class AddMaterialCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var TransferExecutor  */
    private $transferExecutor;

    public function __construct(OrderRepositoryObj $orderRepo,  WorkerRepositoryObj $workerRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;
        $this->transferExecutor = new TransferExecutor();
    }

    public function addMaterial($order_id, $worker_id, $materialCode)
    {
        /** @var OrderEntity $order */
        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($worker_id);
        
        $orderMaterial = $order->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);

        $needAmount = $orderMaterial->need - $orderMaterial->stock;
        
        if ($needAmount > $workerMaterial->value) {
            throw new DefecitMaterialException;
        };

        $transfer = new OrderMaterialTransfer($order, $worker, $materialCode, $needAmount);

        \DB::beginTransaction();
        try {
            $this->transferExecutor->executeTransfer($transfer);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }

        $order->checkStockMaterials();

        \DB::commit();
    }
}
