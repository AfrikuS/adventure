<?php

namespace App\Modules\Timer\Persistence\Dao;

class BodalkaResultDao
{
    private $table = 'jobs_bodalka_result';

    public function create($user_id, $gold, $oil)
    {
        return
            \DB::table($this->table)->insert([
                'id' => $user_id,
                'gold' => $gold,
                'oil' => $oil,
            ]);
    }

    public function findBy($user_id)
    {
        $result =
            \DB::table($this->table)
                ->select(['id', 'gold', 'oil'])
                ->find($user_id);
        
//        if (null === $result) {
//            return null;
//        }
//
        return $result;
    }

    public function delete($user_id)
    {
        \DB::table($this->table)->delete($user_id);
    }
}
