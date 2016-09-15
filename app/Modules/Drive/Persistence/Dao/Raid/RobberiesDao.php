<?php

namespace App\Modules\Drive\Persistence\Dao\Raid;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class RobberiesDao
{
//CREATE TABLE IF NOT EXISTS `` (
//`raid_id` INT UNSIGNED NOT NULL,
//`vehicle_id` INT UNSIGNED NOT NULL,
//`victim_id` INT UNSIGNED NOT NULL,
//`status` VARCHAR(255) NOT NULL,
//`start_robbery` DATETIME NOT NULL,
//PRIMARY KEY (raid_id),
//FOREIGN KEY (raid_id) REFERENCES drive_raids(id),
//FOREIGN KEY (vehicle_id) REFERENCES drive_raids(vehicle_id),
//FOREIGN KEY (victim_id) REFERENCES hero_resources(id)
//);
    private $table = 'driver_raid_robberies';
    // raid_id = driver_id


    public function create($raid_id, $vehicle_id, $status, $startedAt, $victim_id)
    {
        $robbery_id =
            \DB::table($this->table)->insert([
                'raid_id' => $raid_id,
                'vehicle_id' => $vehicle_id,
                'status'     => $status,
                'start_robbery' => $startedAt,
                'victim_id'     => $victim_id,
            ]);

        return $robbery_id;
    }

    public function find($raid_id)
    {
        $robberyData =
            \DB::table($this->table)
                ->select(['raid_id', 'status', 'victim_id', 'vehicle_id', 'start_robbery'])
                ->where('raid_id', $raid_id)
                ->first();
        
        if (null === $robberyData) {
            throw new EntityNotFound_Exception;
        }

        return $robberyData;
    }

    public function update($id, $status, $victim_id)
    {
        return
            \DB::table($this->table)
                ->where('raid_id', $id)
                ->update([
                    'status' => $status,
                    'victim_id' => $victim_id,
                ]);
    }

    public function delete($id)
    {
        return
            \DB::table($this->table)
                ->where('raid_id', $id)
                ->delete();
    }
}
