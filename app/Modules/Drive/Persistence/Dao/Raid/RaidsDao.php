<?php

namespace App\Modules\Drive\Persistence\Dao\Raid;

class RaidsDao
{
    private $table = 'drive_raids';
    // id = driver_id
    
    
    public function findSimpleRaidByDriver($driver_id)
    {
        $raidData =
            \DB::table($this->table)

                ->select(['id', 'vehicle_id', 'status', 'reward', 'start_raid', 'victim_id'])
                ->find($driver_id);

        return $raidData;
    }

    public function create($driver_id, $vehicle_id, $startTime, $status)
    {
        $raid_id =
            \DB::table($this->table)->insertGetId([
                'id' => $driver_id,
                'vehicle_id' => $vehicle_id,
                'status'     => $status,
                'reward'     => 0,
                'start_raid' => $startTime,

                'victim_id'      => null,
                'robbery_status' => null,
            ]);

        return $raid_id;
    }

    public function findRobbery($raid_id)
    {
        $robberyData =
            \DB::table($this->table)
                ->select(['id', 'status', 'robbery_status', 'victim_id', 'vehicle_id'])
                ->find($raid_id);

        return $robberyData;
    }

    public function updateRobberyData($id, $status, $robberyStatus, $victim_id)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'robbery_status' => $robberyStatus,
                    
                    'victim_id' => $victim_id,
                ]);
    }

    public function updateRaidData($id, $status, $victim_id, $reward)  
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'victim_id' => $victim_id,
                    'reward' => $reward,
                ]);
    }
    
    public function delete($raid_id)
    {
        return
            \DB::table($this->table)->delete($raid_id);
    }

    public function deleteRobbery($robbery_id)
    {
        return
            \DB::table($this->table)
                ->where('id', $robbery_id)
                ->update([
                    'victim_id' => null,
                    'robbery_status' => null,
                ]);
    }
}
