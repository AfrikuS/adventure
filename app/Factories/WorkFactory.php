<?php

namespace App\Factories;

use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker;
use App\Models\Work\Worker\WorkerMaterial;
use App\Models\Work\Worker\WorkerSkill;

class WorkFactory
{
    public static function createWorker($user): Worker
    {
        return Worker::create([
            'id' => $user->id,
            'status' => 'free',
        ]);
    }


    public static function createWorkerSkill(Worker $worker, string $code)
    {
        return WorkerSkill::create([
            'worker_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);
    }

    public static function createWorkerMaterial($worker, $code)
    {
        return WorkerMaterial::create([
            'user_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);
    }

}
