<?php

namespace App\Persistence\Services\Work;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\Work\Order\WorkerMaterial;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class DecrementMaterialEvent
{
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;

    public function __construct(WorkerMaterialsRepo $workerMaterialsRepo)
    {
        $this->workerMaterialsRepo = $workerMaterialsRepo;
    }

    public function handle($worker_id, $code, $amount)
    {
        /** @var WorkerMaterial $material */
        $material = $this->workerMaterialsRepo->findBy($worker_id, $code);

        if (null == $material) {

            throw new NotEnoughMaterialException;
        }
        else {
            
            $material->decrAmount($amount);

            $this->workerMaterialsRepo->update($material);
        }
    }

}
