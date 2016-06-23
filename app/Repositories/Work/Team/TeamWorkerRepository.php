<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamWorker;
use App\Models\Work\UserMaterial;
use App\Models\Work\WorkUserSkill;
use App\Repositories\Work\UserMaterialsRepository;

class TeamWorkerRepository
{
    public static function createWorker($user): TeamWorker
    {
        return TeamWorker::create([
            'id' => $user->id,
            'status' => 'free',
        ]);
    }

    public static function findById($id): TeamWorker
    {
        return TeamWorker::select('id', 'team_id', 'status')->find($id);
    }

    public static function findWithMaterialsAndSkillsById($id): TeamWorker
    {
        return TeamWorker::select('id', 'team_id', 'status')
            ->with(['materials' => function ($query) {
                $query->select('id', 'user_id', 'code', 'value');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'worker_id', 'code', 'value');
            }])
            ->find($id);
//        return TeamWorker::find($id);
    }

    public static function findOrCreate($user)
    {
        if (null === TeamWorker::find($user->id)) {
            TeamWorkerRepository::createWorker($user);
        }
    }

    public static function getLeader(PrivateTeam $privateTeam)
    {
        return TeamWorker::find($privateTeam->leader_worker_id);
    }

    public static function workerHaveNotTeam(TeamWorker $worker): bool
    {
        return $worker->team === null;
    }

    public static function belongToTeam(TeamWorker $worker, PrivateTeam $team)
    {
        return $team->id == $worker->team_id;
    }

    public static function hasAmountMaterialForOrder(TeamWorker $worker, TeamOrder $order, string $materialCode)
    {
        $orderMaterial = TeamOrderRepository::getMaterialByCode($order, $materialCode);
        $userMaterial = TeamWorkerRepository::getMaterialByCode($worker, $materialCode);

//        if ($userMaterial != null) {
            $needAmount = $orderMaterial->need - $orderMaterial->stock;
            return $needAmount <= $userMaterial->value;
//        }
        
        return false;
    }



    public static function getMaterialByCode(TeamWorker $worker, string $code)
    {
        $index = $worker->materials->search(function ($material, $key) use ($code) {
            return $material->code == $code;
        });

        if (is_int($index)) {
            return $worker->materials->get($index);
        }

        $material = UserMaterial::create([
            'user_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);

        $worker->materials->push($material);

        return $material;
    }

    // dynamic data => that porn
    public static function getSkillByCode(TeamWorker $worker, $code)
    {
        $index = $worker->skills->search(function ($skill, $key) use ($code) {
            return $skill->code == $code;
        });

        if (is_int($index)) {
            return $worker->skills->get($index);
        }

        $skill = WorkUserSkill::create([
            'worker_id' => $worker->id,
            'code' => $code,
            'value' => 0,
        ]);

        $worker->skills->push($skill); // in db it exist yet

        return $skill;
    }

    public static function findWithTeamById($id)
    {
        return TeamWorker::select('id', 'team_id', 'status')
            ->with('team')
            ->find($id);
    }



//    public static function getMaterialByCode(TeamWorker $worker, string $materialCode)
//    {
//        return UserMaterial::
//            select('id', 'code', 'value')
//            ->where('user_id', $worker->id)
//            ->where('code', $materialCode)
//            ->first();
//    }

//    public static function addSkillToWorkerByCode(TeamWorker $worker, string $skillCode)
//    {
//        $skill = TeamWorkerRepository::getSkillByCode($worker, $skillCode);
//
//        $skill->increment('value', 11);
//    }

//    public static function getSkillByCode(TeamWorker $worker, string $skillCode)
//    {
//        $userSkill = WorkUserSkill::
//            select('id', 'code', 'value')
//            ->where('user_id', $worker->id)
//            ->where('code', $skillCode)
//            ->first();
//
//        if ($userSkill == null) {
//            $userSkill = WorkUserSkill::create([
//                'user_id' => $worker->id,
//                'code' => $skillCode,
//                'value' => 0,
//            ]);
//        }
//
//        return $userSkill;
//    }

}
