<?php

namespace App\Modules\Work\Domain\Entities\Worker;

use App\Exceptions\NotEnoughMaterialException;

class WorkerMaterial
{
    public $id;
    public $code;
    public $value;
    public $user_id;

    public function __construct(\stdClass $workerMaterialData)
    {
        $this->id = $workerMaterialData->id;
        $this->code = $workerMaterialData->code;
        $this->value = $workerMaterialData->value;
        $this->user_id = $workerMaterialData->user_id;
    }

    public function incrAmount($amount)
    {
        $this->value += $amount;
    }

    public function decrAmount($amount)
    {
        if ($this->value < $amount) {

            throw new NotEnoughMaterialException;
        }

        $this->value -= $amount;
    }
}
