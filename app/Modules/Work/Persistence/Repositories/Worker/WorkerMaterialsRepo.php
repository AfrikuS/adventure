<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Worker\WorkerMaterial;
use App\Modules\Work\Persistence\Dao\Worker\WorkerMaterialsDao;

class WorkerMaterialsRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    public function __construct(WorkerMaterialsDao $workerMaterialsDao)
    {
        $this->materialsDao = $workerMaterialsDao;
    }

    public function update(WorkerMaterial $material)
    {
        $this->materialsDao->update(
            $material->id,
            $material->value
        );
    }

    public function getBy($worker_id)
    {
        $materialsData = $this->materialsDao->getMaterials($worker_id);
        
        return $materialsData;
    }

    public function findBy($worker_id, $code) 
    {
        $material = EntityStore::get(WorkerMaterial::class, 'worker:'.$worker_id);

        if ($material != null) {
            return $material;
        }

        $materialData = $this->materialsDao->find($worker_id, $code);

        $material = new WorkerMaterial($materialData);


        EntityStore::add($material, 'worker:'.$worker_id);

        return $material;
    }

    public function create($worker_id, $code, $amount)
    {
        $this->materialsDao->create($worker_id, $code, $amount);
    }

    public function getForOrder($user_id, $materials_codes)
    {
        $materials = $this->materialsDao->getByCodes($user_id, $materials_codes);
        
        return $materials;
    }
}
