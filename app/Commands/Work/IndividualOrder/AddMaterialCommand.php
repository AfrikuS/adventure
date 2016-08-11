<?php

namespace App\Commands\Work\IndividualOrder;

use App\Entities\Work\OrderEntity;
use App\Exceptions\NotEnoughMaterialException;
use App\Models\Work\Worker;
use App\Persistence\Models\Work\Order;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Services\Transfers\OrderMaterialTransfer;
use App\Services\Transfers\TransferExecutor;

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

    // transfer material
    public function addMaterial($order_id, $worker_id, $materialCode)
    {
//        /** @var OrderEntity $order */
//        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);
//        /** @var Worker $worker */
//        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($worker_id);


        $workerRepo = new WorkerRepo();

        $worker = $workerRepo->findWithMaterialsById($worker_id);

        $orderRepo = new OrderRepo();
        /** @var Order $order */
        $order = $orderRepo->findOrderWithMaterialsById($order_id);



        $amount = $order->getNeedMaterialAmount($materialCode);
        
        // start_transaction - try
        
        $worker->subtractMaterial($materialCode, $amount);
        $workerRepo->updateMaterialAmount($worker, $materialCode);




        $order->stockMaterial($materialCode, $amount);



        $orderRepo->updateMaterialAmount($order, $materialCode);


//        $order->checkStockMaterials();

        // end_transaction
        
/*        $orderMaterial = $order->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);

        $needAmount = $orderMaterial->need - $orderMaterial->stock;
        
        if ($needAmount > $workerMaterial->value) {
            throw new NotEnoughMaterialException;
        };

        $transfer = new OrderMaterialTransfer($order, $worker, $materialCode, $needAmount);

        \DB::beginTransaction();
        try 
        {
            $this->transferExecutor->executeTransfer($transfer);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }

        $order->checkStockMaterials();

        \DB::commit();*/
    }
}
