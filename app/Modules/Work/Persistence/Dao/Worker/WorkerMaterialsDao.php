<?php

namespace App\Modules\Work\Persistence\Dao\Worker;

class WorkerMaterialsDao
{
    private $table = 'work_worker_materials';

    /** @deprecated  */
    public function save($id, $value)
    {
        if (isset($id)) {

            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'value'  => $value,
                ]);
        }
        else {
        }
    }

    public function create($id, $code, $value)
    {
        \DB::table($this->table)
            ->insertGetId([
                'user_id' => $id,
                'code' => $code,
                'value' => $value,
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

    public function find($worker_id, $code)
    {
        $material = \DB::table($this->table)
            ->select(['id', 'user_id', 'code', 'value'])
            ->where('user_id', $worker_id)
            ->where('code', $code)
            ->first();

        return $material;
    }

    public function update($id, $value)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'value'  => $value,
            ]);
    }

    public function getByCodes($user_id, $codes)
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'user_id', 'code', 'value'])
            ->where('user_id', $user_id)
            ->whereIn('code', $codes)
            ->get();

        return $materials;
    }
}
