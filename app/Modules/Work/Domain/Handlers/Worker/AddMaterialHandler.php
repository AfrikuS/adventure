<?php

namespace App\Modules\Work\Domain\Handlers\Worker;


use App\Modules\Work\Domain\Commands\Worker\AddMaterial;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerMaterialsRepo;

class AddMaterialHandler
{
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;

    public function __construct()
    {
        $this->workerMaterialsRepo = app('WorkerMaterialsRepo');
    }

    public function handle(AddMaterial $command)
    {
        $material = $this->workerMaterialsRepo->findBy($command->worker_id, $command->materialCode);

        if (null == $material) {

            $this->workerMaterialsRepo->create(
                $command->worker_id,
                $command->materialCode,
                $command->amount
            );
        }
        else {

            $material->incrAmount($command->amount);

            $this->workerMaterialsRepo->update($material);
        }
    }
}
