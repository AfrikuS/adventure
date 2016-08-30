<?php

namespace App\Modules\Drive\Persistence\Dao;

class DriversDao
{
    private $table = 'drive_drivers';
    
    public function find($id)
    {
        $driver = \DB::table($this->table)
            ->select(['id', 'status', 'active_vehicle_id'])
            ->find($id);

        return $driver;
    }

/*    public function getAll()
    {
        $domains = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->get();

        return $domains;
    }
*/
    public function createOnce($user_id)
    {
        $driver_id = \DB::table($this->table)->where('id', $user_id)->value('id');
        
        if ($driver_id != null) {
            
            return true;
        }
        
        $driver_id =
            \DB::table($this->table)->insertGetId([
                'id' => $user_id,
                'status' => 'free',
                'active_vehicle_id' => null,
            ]);

        return $driver_id;
    }

    public function update($id, $status)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                ]);
    }
}
