<?php

namespace App\Commands\Work\IndividualOrder;

use App\Repositories\Work\OrderRepositoryObj;

class AnalyseCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function analyseOrder($order_id)
    {
        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);


//        if ($order->)

//        \DB::beginTransaction();
//
//        try {
//
//            $missingMaterialCodes = $this->selectMissingCodes($worker, $order);
//
//            $this->createMissingMaterials($worker, $missingMaterialCodes);
//
//        }
//        catch(\Exception $e)
//        {
//            \DB::rollback();
//            throw $e;
//        }
//
//        $order->estimate($worker_id);
//
//        \DB::commit();
    }
}
