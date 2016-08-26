<?php

namespace App\Modules\Work\Domain\Commands\Worker;

class AddMaterial
{
    public $worker_id;
    
    public $materialCode;
    
    public $amount;

    /**
     * AddMaterial constructor.
     * @param $amount
     * @param $materialCode
     * @param $worker_id
     */
    public function __construct($worker_id, $materialCode, $amount)
    {
        $this->worker_id = $worker_id;
        $this->materialCode = $materialCode;
        $this->amount = $amount;
    }
}
