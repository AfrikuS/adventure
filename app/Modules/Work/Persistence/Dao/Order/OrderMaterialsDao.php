<?php

namespace App\Modules\Work\Persistence\Dao\Order;

use App\Persistence\Models\Work\Order\OrderMaterial;

class OrderMaterialsDao
{
    private $table = 'work_order_materials';
    
    public function getByOrder($order_id)
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'order_id', 'code', 'need', 'stock'])
            ->where('order_id', $order_id)
            ->get();

        return $materials;
    }

    public function create(int $order_id, string $code, int $need, int $stock)
    {
        return
            \DB::table($this->table)
                ->insertGetId([
                    'order_id'  => $order_id,
                    'code'  => $code,
                    'need'  => $need,
                    'stock'  => $stock,
                ]);
    }
    
    public function save($material)
    {
        if (isset($material->id)) {

            \DB::table($this->table)
                ->where('id', $material->id)
                ->update([
                    'stock'  => $material->stock,
                ]);
        }
        else
        {
            return \DB::table($this->table)
                ->insertGetId([
                    'order_id'  => $material->order_id,
                    'code'  => $material->code,
                    'need'  => $material->need,
                    'stock'  => $material->stock,
                ]);
        }
    }

    public function update($id, $stock)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'stock'  => $stock,
            ]);
    }

    public function findBy($order_id, $code)
    {
        $materialData = \DB::table($this->table)
            ->select(['id', 'order_id', 'code', 'need', 'stock'])
            ->where('order_id', $order_id)
            ->where('code', $code)
            ->first();

        return $materialData;
    }

    public function getSummarizeNeed($order_id)
    {
        $needSum = \DB::table($this->table)
            ->where('order_id', $order_id)
            ->sum('need');

        return $needSum;
    }

    public function getSummarizeStocked($order_id)
    {
        $stockedSum = \DB::table($this->table)
            ->where('order_id', $order_id)
            ->sum('stock');

        return $stockedSum;
    }

    public function deleteByOrder($order_id)
    {
        return \DB::table($this->table)
            ->where('order_id', $order_id)
            ->delete();
    }

    /*    public function create($material)
        {
            return \DB::table($this->table)
                ->insertGetId([
                    'code'  => $material->code,
                    'order_id'  => $material->order_id,
                    'need'  => $material->need,
                    'stock'  => $material->stock,
                ]);
        }*/

}
