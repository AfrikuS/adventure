<?php

namespace App\Factories\Work;

use App\Models\Work\Worker\WorkerInstrument;

class WorkerFactory
{
    public static function createWorkerInstrument(Worker $worker, string $instrumentCode)
    {
        return WorkerInstrument::create([
            'worker_id' => $worker->id,
            'code' => $instrumentCode,
            'skill_level' => 0,
        ]);
    }
}
