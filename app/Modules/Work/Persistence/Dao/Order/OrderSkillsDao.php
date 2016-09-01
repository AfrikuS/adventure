<?php

namespace App\Modules\Work\Persistence\Dao\Order;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class OrderSkillsDao
{
    private $table = 'work_order_skills';

    public function getAllByOrderId($order_id)
    {
        $skillsData = \DB::table($this->table)
            ->select(['id', 'order_id', 'domain_id', 'need_times', 'stock_times'])
            ->where('order_id', $order_id)
            ->get();

        return $skillsData;
    }

    public function create($order_id, $domain_id, $need, $stock = 0)
    {
        \DB::table($this->table)
            ->insertGetId([
                'order_id' => $order_id,
                'domain_id' => $domain_id,
                'need_times' => $need,
                'stock_times' => $stock,
            ]);
    }
    
    public function update($id, $stock)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'stock_times'  => $stock,
            ]);
    }

    public function findBy($order_id)
    {
        $skillData = \DB::table($this->table)
            ->select(['id', 'order_id', 'domain_id', 'need_times', 'stock_times'])
            ->where('order_id', $order_id)
            ->first();

        if (null == $skillData) {
            throw new EntityNotFound_Exception;
        }

        return $skillData;
    }

    public function deleteByOrder($order_id)
    {
        return \DB::table($this->table)
            ->where('order_id', $order_id)
            ->delete();
    }
}
