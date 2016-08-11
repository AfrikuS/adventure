<?php

namespace App\Persistence\Dao\Work;

class WorkerMaterialsDao
{
    private $table = 'work_worker_materials';

    public function save($material)
    {
        \DB::table($this->table)
            ->where('id', $material->id)
            ->update([
                'value'  => $material->value,
            ]);
    }

    public function getMaterials($worker_id)
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'user_id', 'code', 'value'])
            ->where('user_id', $worker_id)
            ->get();

        return $materials;
    }

}
