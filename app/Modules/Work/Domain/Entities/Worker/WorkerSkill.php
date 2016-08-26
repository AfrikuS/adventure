<?php

namespace App\Modules\Work\Domain\Entities\Worker;

class WorkerSkill
{
    public $id;
    public $worker_id;
    public $code;
    public $value;

    public function __construct(\stdClass $workerSkillData)
    {
        $this->id = $workerSkillData->id;
        $this->worker_id = $workerSkillData->worker_id;
        $this->code = $workerSkillData->code;
        $this->value = $workerSkillData->value;
    }

    public function increment($amount)
    {
        $this->value += $amount;
    }
}
