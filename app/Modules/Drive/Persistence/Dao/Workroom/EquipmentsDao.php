<?php

namespace App\Modules\Drive\Persistence\Dao\Workroom;

class EquipmentsDao
{
    private $table = 'drive_workroom_equipment';

    /*CREATE TABLE IF NOT EXISTS `` (
    `driver_id` INT UNSIGNED NOT NULL,

    `refueler_level` INT UNSIGNED NOT NULL DEFAULT 0,
    `lift_level` INT UNSIGNED NOT NULL DEFAULT 0,
    `recoverer_level` INT UNSIGNED NOT NULL DEFAULT 0,

    PRIMARY KEY (driver_id),
    FOREIGN KEY (driver_id) REFERENCES drive_drivers(id)
        */

/*    public function findBy($driver_id)
    {
        $equipmentData = \DB::table($this->table)
            ->select(['driver_id', 'refueler_level', 'lift_level', 'recoverer_level AS restorer_level'])
            ->where('driver_id', $driver_id)
            ->first();

        if (null === $equipmentData) {
            throw new EntityNotFound_Exception;
        }

        return $equipmentData;
    }*/


    public function findRefuelerBy($driver_id)
    {
        $refueler =
            \DB::table($this->table)
                ->select(['driver_id', 'refueler_level AS level'])
                ->where('driver_id', $driver_id)
                ->first();

        return $refueler;
    }

    public function updateRefueler($driver_id, $level)
    {
        \DB::table($this->table)
            ->where('driver_id', $driver_id)
            ->update([
                'refueler_level' => $level,
            ]);
    }
    
    public function create($driverId, $liftLevel, $recovererLevel, $refuelerLevel)
    {
        $equipment_id =
            \DB::table($this->table)->insert([
                'recoverer_level' => $recovererLevel,
                'lift_level' => $liftLevel,
                'refueler_level' => $refuelerLevel,
                'driver_id' => $driverId,
            ]);

        return $equipment_id;
    }

    public function deleteByDriver($driver_id)
    {
        return
            \DB::table($this->table)->where('driver_id', $driver_id)->delete();
    }

    /** @deprecated  */
    public function find($driver_id)
    {
        $equipments =
            \DB::table($this->table)
                ->select(['driver_id', 'refueler_level', 'lift_level', 'recoverer_level AS restorer_level'])
                ->where('driver_id', $driver_id)
                ->first();

        return $equipments;
    }

    public function updateRepairer($driver_id, $level)
    {
        \DB::table($this->table)
            ->where('driver_id', $driver_id)
            ->update([
                'repairer_level' => $level,
            ]);
    }

    public function findRepairerBy($driver_id)
    {
        return
            \DB::table($this->table)
                ->select(['driver_id', 'repairer_level AS level'])
                ->where('driver_id', $driver_id)
                ->first();
    }
}
