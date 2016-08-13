<?php

namespace App\Persistence\Services\Work;

use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class AddMaterialEvent
{
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;

    public function __construct(WorkerMaterialsRepo $workerMaterialsRepo)
    {
        $this->workerMaterialsRepo = $workerMaterialsRepo;
    }

    public function handle($worker_id, $code, $amount)
    {
        $material = $this->workerMaterialsRepo->findBy($worker_id, $code);

        if (null == $material) {

            $this->workerMaterialsRepo->create($worker_id, $code, $amount);
        }
        else {

            $material->incrAmount($amount);

            $this->workerMaterialsRepo->update($material);
        }
    }
}
