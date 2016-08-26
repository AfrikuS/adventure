<?php

namespace App\Modules\Work\Domain\Entities\Worker;

use App\Exceptions\NotEnoughMaterialException;

class WorkerInstrument
{
    public $id;
    public $worker_id;
    public $code;
    public $charge;

    public function __construct(\stdClass $workerInstrumentData)
    {
        $this->id = $workerInstrumentData->id;
        $this->worker_id = $workerInstrumentData->worker_id;
        $this->code = $workerInstrumentData->code;
        $this->charge = $workerInstrumentData->charge;
    }

    public function incrCharge($amount)
    {
        $this->charge += $amount;
    }

    public function decrCharge($amount)
    {
        if ($this->charge < $amount) {
            throw new NotEnoughMaterialException;
        }

        $this->charge -= $amount;
    }
}
