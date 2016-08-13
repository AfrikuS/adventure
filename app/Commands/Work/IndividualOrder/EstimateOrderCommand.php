<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Worker;
use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use App\Persistence\Services\Work\Order\OrderBuilderService;
use App\Persistence\Services\Work\Order\OrderService;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;

class EstimateOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;
    /** @var  WorkerRepositoryObj */
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

    public function estimateOrder($order_id, $worker_id)
    {

        $orderBuilderService = new OrderBuilderService($this->materialsRepo,
                                                        $this->orderMaterialsRepo
        );

        $orderService = new OrderService($this->orderRepo);
        




        \DB::beginTransaction();
        try {

            $orderBuilderService->generateMaterials($order_id, 2);



            $orderService->changeStatusAfterEstimating($order_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
        \DB::commit();
    }

    private function searchMissingMaterials($workerMaterials, $orderMaterials)
    {
        $missingMaterials = [];
        
        foreach ($orderMaterials as $oMaterial) {

            
            if (! array_key_exists($oMaterial->code, $workerMaterials)) {
                
                $missingMaterials[] = $oMaterial;
            }
        }
        
        return $missingMaterials;
    }

    /*    private function createMissingMaterials(Worker $worker, Collection $codes)
        {
            $codes->each(function ($code, $key) use ($worker) {
    
                WorkerFactory::createWorkerMaterial($worker, $code);
            });
        }
    
        private function createMissingSkills(Worker $worker, Collection $codes)
        {
            $codes->each(function ($code, $key) use ($worker) {
    
                WorkerFactory::createWorkerSkill($worker, $code);
            });
        }
    
        private function selectMissingMaterialCodes($worker, $order)
        {
            $workerMaterialCodes = $worker->materials->map(function ($material, $key) {
                return $material->code;
            })->toArray();
    
            $missingCodes = $order->materials->reject(function ($material) use ($workerMaterialCodes) {
                return in_array($material->code,  $workerMaterialCodes);
            })->pluck('code');
    
            return $missingCodes;
        }
    
        private function selectMissingSkillCodes($worker, $order)
        {
            $orderCodes = Collection::make($order->kind_work_title);
    
            $workerSkillCodes = $worker->skills->map(function ($skill, $key) {
                return $skill->code;
            })->toArray();
    
            $missingCodes = $orderCodes->reject(function ($code) use ($workerSkillCodes) {
                return in_array($code,  $workerSkillCodes);
            })->pluck('code');
    
            return $missingCodes;
        }*/
}
