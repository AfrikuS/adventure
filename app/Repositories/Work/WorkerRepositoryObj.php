<?php

namespace App\Repositories\Work;

use App\Entities\Work\Team\TeamWorker;
use App\Factories\WorkerFactory;
use App\Models\Work\Order;
use App\Models\Work\Worker;
use App\Repositories\Work\Team\WorkerRepository;

class WorkerRepositoryObj
{
    public function findWithMaterialsAndSkillsById($id): Worker
    {
        return WorkerRepository::findWithMaterialsAndSkillsById($id);
    }

    public function selectWorkerMaterialsNeedForOrder($order, Worker $worker)
    {
        $orderMaterials = $order->materials;
        $workerMaterials = $worker->materials;

        $needMaterialsCodes = $orderMaterials->map(function ($material, $key) {
            return $material->code;
        })->toArray();

        return $workerMaterials->filter(function ($material) use ($needMaterialsCodes) {
            return in_array($material->code, $needMaterialsCodes);
        });
    }

    public function upSkillByCode(Worker $worker, $skillCode, $amount)
    {
        $skill = $worker->getSkillByCode($skillCode);

        if ($skill == null)
        {
            WorkerFactory::createWorkerSkill($worker, $skillCode, $amount);
        }
        else {
            $skill->increment('value', $amount);
        }
    }
    
    public function addMaterialToWorker(Worker $worker, $code, $amount)
    {
        $material = $worker->getMaterialByCode($code);
        
        if ($material == null) 
        {
            WorkerFactory::createWorkerMaterial($worker, $code, $amount);
        }
        else {
            $material->increment('value', $amount);
        }
    }

    public function addInstrumentToWorker(Worker $worker, $code, $charges)
    {
        $instrument = $worker->getInstrumentByCode($code);

        if ($instrument == null)
        {
            WorkerFactory::createWorkerInstrument($worker, $code, $charges);
        }
        else {
            $instrument->increment('skill_level', $charges);
        }
    }

    public function findWithTeamById($worker_id)
    {
        return Worker::select('id', 'team_id', 'status')
            ->with(['team' => function ($query) {
                $query->select('id', 'leader_worker_id', 'kind_work', 'status');
            }])
            ->find($worker_id);
    }

    public function findSimpleById($id): Worker
    {
        return Worker::select('id', 'team_id', 'status')->find($id);
    }

    public function getTeamWorkerSimpleById($id)
    {
        $worker = Worker::select('id', 'team_id', 'status')->find($id);
        
        return new TeamWorker($worker);
    }

}
