<?php

namespace App\Modules\Drive\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class VehiclesDao
{
    private $table = 'drive_vehicles';
    
    const STATUS_NORMAL = 'normal';

    public function create($driver_id)
    {
        
    }

    public function createFirst($driver_id, $title = 'беглый Джек-сон')
    {
        $vehicle_id = 
            \DB::table($this->table)->insertGetId([
                'driver_id'      => $driver_id,
                'acceleration'   => 30,
                'stability'      => 40,
                'mobility'       => 50,
                'fuel_level'     => 650,
                'damage_percent' => 0,
                'status'          => self::STATUS_NORMAL,
            ]);

        return $vehicle_id;
    }

    public function findActiveVehicle($driver_id)
    {
        $vehicleData = \DB::table($this->table)
            ->select(['id', 'driver_id', 'acceleration', 'stability', 'mobility', 'status'])
            ->where('driver_id', $driver_id)
            ->first();

        if (null === $vehicleData) {
            throw new EntityNotFound_Exception;
        }

        return $vehicleData;
    }

    public function findViewVehicle($driver_id)
    {
        $vehicleData = \DB::table($this->table)
            ->select(['id', 'driver_id', 'damage_percent', 'acceleration', 'stability', 'mobility',
                        'fuel_level', 'status'])
            ->first();

        if (null === $vehicleData) {
            throw new EntityNotFound_Exception;
        }

        return $vehicleData;
    }

    public function updateRepair($id, $status, $damage_percent, $fuel_level)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'damage_percent' => $damage_percent,
                    'fuel_level' => $fuel_level,
                ]);
    }

    public function findVehicleForRepair($id)
    {
        $vehicleData = \DB::table($this->table)
            ->select(['id', 'status', 'damage_percent', 'fuel_level'])
            ->find($id);
        
        return $vehicleData;
    }

    public function findRobberyVehicle($vehicle_id)
    {
        $vehicleData = \DB::table($this->table)
            ->select(['id', 'status', 'damage_percent', 'fuel_level', 'mobility'])
            ->find($vehicle_id);

        return $vehicleData;
    }

    public function find($id)
    {
        $vehicleData = \DB::table($this->table)
            ->select(['id', 'driver_id', 'acceleration', 'stability', 'mobility', 
                      'status', 'damage_percent', 'fuel_level'])
            ->find($id);

        return $vehicleData;
    }
}
