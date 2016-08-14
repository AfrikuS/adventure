<?php

namespace App\Persistence\Dao\Work\Worker;

class WorkerSkillsDao
{
    private $table = 'work_worker_skills';

    public function getAll($worker_id)
    {
        $skills = \DB::table($this->table)
            ->select(['id', 'worker_id', 'code', 'value'])
            ->where('worker_id', $worker_id)
            ->get();

        return $skills;
    }

    public function find($worker_id, $code)
    {
        $skill = \DB::table($this->table)
            ->select(['id', 'worker_id', 'code', 'value'])
            ->where('worker_id', $worker_id)
            ->where('code', $code)
            ->first();

        return $skill;
    }

    public function update($skill)
    {
        \DB::table($this->table)
            ->where('id', $skill->id)
            ->update([
                'value'  => $skill->value,
            ]);
    }

    public function create($skill)
    {
        return
            \DB::table($this->table)->insertGetId([
                    'worker_id' => $skill->worker_id,
                    'code' => $skill->code,
                    'value' => 0,
                ]);
    }

}
