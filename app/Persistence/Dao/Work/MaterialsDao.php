<?php

namespace App\Persistence\Dao\Work;

class MaterialsDao
{
    private $table = 'work_order_materials';
    
    public function getOrderMaterialsById($order_id)
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'order_id', 'code', 'need', 'stock'])
            ->where('order_id', $order_id)
            ->get();

        return $materials;
    }

    public function save($material)
    {
        \DB::table($this->table)
            ->where('id', $material->id)
            ->update([
                'stock'  => $material->stock,
            ]);
    }
}
