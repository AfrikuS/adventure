<?php

namespace App\Persistence\Models\Work\Worker;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\DataObject;
use App\Persistence\Repositories\Work\WorkerInstrumentsRepo;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class WorkerInstrument extends DataObject
{
    protected function getAttributes()
    {
        return ['id', 'worker_id', 'code', 'charge'];
    }

    public function incrCharge($amount)
    {
        $this->dataObject->charge += $amount;
    }

    public function decrCharge($amount)
    {
        if ($this->dataObject->charge < $amount) {
            throw new NotEnoughMaterialException;
        }

        $this->dataObject->charge -= $amount;
    }
}
