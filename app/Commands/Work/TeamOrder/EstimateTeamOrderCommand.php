<?php

namespace App\Commands\Work\TeamOrder;

use App\Factories\WorkerFactory;
use App\Models\Work\Worker;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Entities\Work\TeamOrderEntity;
use Illuminate\Support\Collection;

class EstimateTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;

    public function __construct(TeamOrderRepositoryObj $orderRepo, WorkerRepositoryObj $workerRepo)
    {
        $this->teamOrderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;
    }

    public function estimateTeamOrder($order_id, $worker_id)
    {
        /** @var TeamOrderEntity $order */
        $order = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);
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

            $order->estimate();
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
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
        $workerSkillCodes = $worker->skills->map(function ($skill, $key) {
            return $skill->code;
        })->toArray();

        $missingCodes = $order->skills->reject(function ($skill) use ($workerSkillCodes) {
            return in_array($skill->code,  $workerSkillCodes);
        })->pluck('code');

        return $missingCodes;
    }
}
