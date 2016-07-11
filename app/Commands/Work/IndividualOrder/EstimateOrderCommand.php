<?php

namespace App\Commands\Work\IndividualOrder;

use App\Factories\WorkerFactory;
use App\Models\Work\Worker;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Collection;

class EstimateOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;

    public function __construct(OrderRepositoryObj $orderRepo, WorkerRepositoryObj $workerRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;
    }

    public function estimateOrder($order_id, $worker_id)
    {
        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($worker_id);
        
        \DB::beginTransaction();
        try {

            $missingMaterialCodes = $this->selectMissingMaterialCodes($worker, $order);

            if ($missingMaterialCodes->count() > 0) {
                $this->createMissingMaterials($worker, $missingMaterialCodes);
            }

            $missingSkillCodes = $this->selectMissingSkillCodes($worker, $order);
            
            if ($missingSkillCodes->count() > 0) {
                $this->createMissingSkills($worker, $missingMaterialCodes);
            }
            
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        $order->estimate($worker_id);

        \DB::commit();
    }

    private function createMissingMaterials(Worker $worker, Collection $codes)
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
    }
}
