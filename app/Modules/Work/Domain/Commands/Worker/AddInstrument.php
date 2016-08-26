<?php

namespace App\Modules\Work\Domain\Commands\Worker;

class AddInstrument
{
    public $worker_id;
    
    public $instrumentCode;
    
    public $charge;

    /**
     * AddMaterial constructor.
     * @param $worker_id
     * @param $instrumentCode
     * @param $charge
     */
    public function __construct($worker_id, $instrumentCode, $charge)
    {
        $this->worker_id = $worker_id;
        $this->instrumentCode = $instrumentCode;
        $this->charge = $charge;
    }

}
