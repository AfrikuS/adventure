<?php

namespace App\Repositories\Work\Team;

use App\Factories\WorkFactory;
use App\Models\Work\Order;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker;

class WorkerRepository
{
    public static function findById($id): Worker
    {
        return Worker::select('id', 'team_id', 'status')->find($id);
    }

    public static function findWithMaterialsAndSkillsById($id): Worker
    {
        return Worker::select('id', 'team_id', 'status')
            ->with(['materials' => function ($query) {
                $query->select('id', 'user_id', 'code', 'value');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'worker_id', 'code', 'value');
            }])
            ->find($id);
    }

    public static function workerHaveNotTeam(Worker $worker): bool
    {
        return $worker->team === null;
    }

    public static function belongToTeam(Worker $worker, PrivateTeam $team)
    {
        return $team->id == $worker->team_id;
    }


/*    public static function addSkillToWorkerByCode(Worker $worker, string $code)
    {
        $skill = $worker->getSkillByCode($code);

        if ($skill === null) {
            $skill = WorkFactory::createWorkerSkill($worker, $code);
        }

        $worker->skills->push($skill); // check new skill+value in db and worker-memory_obj
    }*/


    // seee worker-model
/*    public static function getMaterialByCode(Worker $worker, string $code)
    {
        $index = $worker->materials->search(function ($material, $key) use ($code) {
            return $material->code == $code;
        });

        if (is_int($index)) {
            return $worker->materials->get($index);
        }

        $material = WorkerMaterial::create([
            'user_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);

        $worker->materials->push($material);

        return $material;
    }*/

    // seee worker-model
    // dynamic data => that porn
/*    public static function getSkillByCode(Worker $worker, $code)
    {
        $index = $worker->skills->search(function ($skill, $key) use ($code) {
            return $skill->code == $code;
        });

        if (is_int($index)) {
            return $worker->skills->get($index);
        }

        $skill = Skill::create([
            'worker_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);

        $worker->skills->push($skill); // in db it exist yet

        return $skill;
    }*/

    public static function findWithTeamById($id)
    {
        return Worker::select('id', 'team_id', 'status')
            ->with('team')
            ->find($id);
    }

    public static function getSingleOrders($worker_id)
    {
        return Order::where('acceptor_user_id', $worker_id)->get();        
    }



//    public static function getMaterialByCode(Worker $worker, string $materialCode)
//    {
//        return WorkerMaterial::
//            select('id', 'code', 'value')
//            ->where('user_id', $worker->id)
//            ->where('code', $materialCode)
//            ->first();
//    }

//    public static function addSkillToWorkerByCode(Worker $worker, string $skillCode)
//    {
//        $skill = WorkerRepository::getSkillByCode($worker, $skillCode);
//
//        $skill->increment('value', 11);
//    }

//    public static function getSkillByCode(Worker $worker, string $skillCode)
//    {
//        $userSkill = Skill::
//            select('id', 'code', 'value')
//            ->where('user_id', $worker->id)
//            ->where('code', $skillCode)
//            ->first();
//
//        if ($userSkill == null) {
//            $userSkill = Skill::create([
//                'user_id' => $worker->id,
//                'code' => $skillCode,
//                'value' => 0,
//            ]);
//        }
//
//        return $userSkill;
//    }

}
