<?php

namespace App\Modules\Work\Domain\Handlers\Worker;

use App\Exceptions\NotEnoughMaterialException;
use App\Modules\Work\Domain\Commands\Worker\DecrementMaterial;
use App\Modules\Work\Domain\Entities\Worker\WorkerMaterial;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerMaterialsRepo;

class DecrementMaterialHandler
{
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;

    public function __construct()
    {
        $this->workerMaterialsRepo = app('WorkerMaterialsRepo');
    }
    
    public function handle(DecrementMaterial $command)
    {
        /** @var WorkerMaterial $material */
        $material = $this->workerMaterialsRepo->findBy($command->worker_id, $command->materialCode);

        if (null == $material) {

            throw new NotEnoughMaterialException;
        }
        else {

            $material->decrAmount($command->amount);

            $this->workerMaterialsRepo->update($material);
        }
    }
}
