<?php

namespace App\Persistence\Models\Work\Worker;

use App\Persistence\Models\DataObject;

class WorkerSkill extends DataObject
{
    public function increment($amount)
    {
        $this->dataObject->value += $amount;
    }

    protected function getAttributes()
    {
        return ['id', 'worker_id', 'code', 'value'];
    }
    
    
}
