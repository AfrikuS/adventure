<?php

namespace App\Factories;

use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker;
use App\Models\Work\Worker\WorkerInstrument;
use App\Models\Work\Worker\WorkerMaterial;
use App\Models\Work\Worker\WorkerSkill;

class WorkerFactory
{
    public static function createWorker($user): Worker
    {
        return Worker::create([
            'id' => $user->id,
            'status' => 'free',
        ]);
    }

    public static function createWorkerSkill(Worker $worker, string $code, $amount = 0)
    {
        return WorkerSkill::create([
            'worker_id' => $worker->id,
            'code' => $code,
            'value' => $amount,
        ]);
    }

    public static function createWorkerMaterial($worker, $code, $amount = 0)
    {
        return WorkerMaterial::create([
            'user_id' => $worker->id,
            'code' => $code,
            'value' => $amount,
        ]);
    }

    public static function createWorkerInstrument($worker, $code, $charges = 0)
    {
        return WorkerInstrument::create([
            'worker_id' => $worker->id,
            'code' => $code,
            'skill_level' => $charges,
        ]);
    }

}
