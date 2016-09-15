<?php

namespace App\Modules\Drive\Persistence\Dao\Raid;

class RaidsDao
{
    private $table = 'drive_raids';
    // id = driver_id
/*`id` INT UNSIGNED NOT NULL,
`vehicle_id` INT UNSIGNED NOT NULL,
`status` VARCHAR(255) NOT NULL,

`victim_id` INT UNSIGNED,
`robbery_status` VARCHAR(255),

`reward` INT UNSIGNED NOT NULL,
`start_raid` DATETIME NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (id) REFERENCES drive_drivers(id),
FOREIGN KEY (vehicle_id) REFERENCES drive_vehicles(id),
FOREIGN KEY (victim_id) REFERENCES hero_resources(id)*/


    public function create($driver_id, $vehicle_id, $status, $startedAt, $reward = 0)
    {
        $raid_id =
            \DB::table($this->table)->insert([
                'id' => $driver_id,
                'vehicle_id' => $vehicle_id,
                'status'     => $status,
                'start_raid' => $startedAt,
                'reward' => $reward,
            ]);

        return $raid_id;
    }
    
    public function update($id, $status, $reward)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'reward' => $reward,
                ]);
    }
    
    public function delete($raid_id)
    {
        return
            \DB::table($this->table)->delete($raid_id);
    }

    public function isExistRaid($id)
    {
        $exist = 
            \DB::table($this->table)
                ->where('id', $id)
                ->exists();

        return $exist;
    }

    public function findBy($driver_id)
    {
        $raidData =
            \DB::table($this->table)
                ->select(['id', 'status', 'vehicle_id', 'start_raid', 'reward'])
                ->find($driver_id);

        return $raidData;
    }
}
