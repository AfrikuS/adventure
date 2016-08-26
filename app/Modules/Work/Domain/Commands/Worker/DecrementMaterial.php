<?php

namespace App\Modules\Work\Domain\Commands\Worker;

class DecrementMaterial
{
    public $worker_id;

    public $materialCode;

    public $amount;

    /**
     * DecrementMaterial constructor.
     * @param $worker_id
     * @param $materialCode
     * @param $amount
     */
    public function __construct($worker_id, $materialCode, $amount)
    {
        $this->worker_id = $worker_id;
        $this->materialCode = $materialCode;
        $this->amount = $amount;
    }
}
