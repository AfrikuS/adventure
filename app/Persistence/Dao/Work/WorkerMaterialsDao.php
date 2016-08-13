<?php

namespace App\Persistence\Dao\Work;

class WorkerMaterialsDao
{
    private $table = 'work_worker_materials';

    public function save(\stdClass $material)
    {
        if (isset($material->id)) {

            \DB::table($this->table)
                ->where('id', $material->id)
                ->update([
                    'value'  => $material->value,
                ]);
        }
        else {
            \DB::table($this->table)
                ->insertGetId([
                    'user_id' => $material->user_id,
                    'code' => $material->code,
                    'value' => $material->value,
                ]);
        }
    }

    public function getMaterials($worker_id)
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'user_id', 'code', 'value'])
            ->where('user_id', $worker_id)
            ->get();

        return $materials;
    }

    public function find($worker_id, $code)
    {
        $material = \DB::table($this->table)
            ->select(['id', 'user_id', 'code', 'value'])
            ->where('user_id', $worker_id)
            ->where('code', $code)
            ->first();

        return $material;
    }

    public function update($material)
    {
        \DB::table($this->table)
            ->where('id', $material->id)
            ->update([
                'value'  => $material->value,
            ]);
    }

}
