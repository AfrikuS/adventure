<?php

namespace App\Commands\Work\IndividualOrder;

use App\Entities\Work\OrderEntity;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use App\Persistence\Services\Work\Order\OrderBuilderService;
use App\Repositories\Work\OrderRepositoryObj;

class GenerateOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    /** @var  WorkerRepo */
    private $workerRepo;


    /** @var MaterialsRepo */
    private $materialsRepo;

    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;



    public function __construct(MaterialsRepo $materialsRepo,
                                OrderMaterialsRepo $orderMaterialsRepo,
                                OrderRepo $orderRepo
    )
    {
        $this->materialsRepo = $materialsRepo;
        $this->orderMaterialsRepo = $orderMaterialsRepo;
        $this->orderRepo = $orderRepo;
    }

    public function generateOrder($worker_id) // createWorkOrderWithMaterials
    {
        $orderBuilderService = new OrderBuilderService(
            $this->materialsRepo,
            $this->orderMaterialsRepo
        );



        \DB::beginTransaction();
        try {


            $orderBuilderService->generateOrderData($worker_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

}
