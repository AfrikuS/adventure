<?php

namespace App\Persistence\Models\Work\Order;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\DataObject;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class WorkerMaterial extends DataObject
{
    /** @var WorkerMaterialsRepo */
    private $materialRepo;

    protected function getAttributes()
    {
        return ['id', 'user_id', 'code', 'value'];
    }

    public function __construct($workerMaterialData, $repo)
    {
        parent::__construct($workerMaterialData);
        
//        $this->dataObject = $workerMaterialData;
        $this->materialRepo = $repo;
    }

    public function incrAmount($amount)
    {
        $this->dataObject->value += $amount;
    }

    public function decrAmount($amount)
    {
        if ($this->dataObject->value < $amount) {
            throw new NotEnoughMaterialException;
        }

        $this->dataObject->value -= $amount;
    }

    /** @deprecated */ // требования, минусы такого подхода
    public function save()
    {
        $this->materialRepo->save($this);
    }
}
