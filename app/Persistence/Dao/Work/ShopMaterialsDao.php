<?php

namespace App\Persistence\Dao\Work;

class ShopMaterialsDao
{
    private $table = 'work_shop_materials';

/*    public function save($material)
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
    }*/

    public function findByCode($code)
    {
        $material = \DB::table($this->table)
            ->select(['id', 'code', 'price'])
            ->where('code', $code)
            ->first();

        return $material;
    }

    public function getAll()
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'code', 'price'])
            ->get();

        return $materials;
    }
}
