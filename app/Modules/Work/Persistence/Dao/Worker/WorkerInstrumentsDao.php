<?php

namespace App\Modules\Work\Persistence\Dao\Worker;

class WorkerInstrumentsDao
{
    private $table = 'work_worker_instruments';

    public function save(\stdClass $instrument)
    {
        if (isset($instrument->id)) {

            \DB::table($this->table)
                ->where('id', $instrument->id)
                ->update([
                    'skill_level'  => $instrument->charge,
                ]);
        }
        else {
            \DB::table($this->table)
                ->insertGetId([
                    'worker_id' => $instrument->worker_id,
                    'code' => $instrument->code,
                    'skill_level' => $instrument->charge,
                ]);
        }
    }

    public function getInstruments($worker_id)
    {
        $instruments = \DB::table($this->table)
            ->select(['id', 'worker_id', 'code', 'skill_level'])
            ->where('worker_id', $worker_id)
            ->get();

        return $instruments;
    }

    public function find($worker_id, $code)
    {
        $instrument = \DB::table($this->table)
            ->select(['id', 'worker_id', 'code', 'skill_level AS charge'])
            ->where('worker_id', $worker_id)
            ->where('code', $code)
            ->first();

        return $instrument;
    }

    public function create(\stdClass $instrument)
    {
        return
            \DB::table($this->table)
                ->insertGetId([
                    'worker_id' => $instrument->worker_id,
                    'code' => $instrument->code,
                    'skill_level' => $instrument->skill_level,
                ]);
    }

    public function update($instrument)
    {
        \DB::table($this->table)
            ->where('id', $instrument->id)
            ->update([
                'skill_level'  => $instrument->charge,
            ]);
    }

}
