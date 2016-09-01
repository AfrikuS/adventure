<?php

namespace App\Modules\Oil\Persistence\Dao;

class ResourceStoresDao
{
    private $table = 'hero_resource_store';

    public function create($hero_id, 
                           $oilCapacityLevel, $oilCapacity, $oilAmount,
                           $petrolCapacityLevel, $petrolCapacity, $petrolAmount,
                           $waterCapacityLevel, $waterCapacity, $waterAmount,
                           $pumpLevel, $oilDistillatorLevel
    )
    {
        \DB::table($this->table)->insert([
            'hero_id' => $hero_id,
            
            'oil_capacity_level' => $oilCapacityLevel,
            'oil_capacity_amount' => $oilCapacity,
            'oil_amount' => $oilAmount,
            
            'petrol_capacity_level' => $petrolCapacityLevel, 
            'petrol_capacity_amount' => $petrolCapacity, 
            'petrol_amount' => $petrolAmount,
            
            'water_capacity_level' => $waterCapacityLevel,  
            'water_capacity_amount' => $waterCapacity,
            'water_amount' => $waterAmount,
            
            'pump_level' => $pumpLevel,
            'oil_distillator_level' => $oilDistillatorLevel,
        ]);
    }

    public function findOilStore($hero_id)
    {
        $oilStore =
            \DB::table($this->table)
                ->select(['hero_id', 'oil_capacity_level', 'oil_capacity_amount', 'oil_amount'])
                ->find($hero_id);

        return $oilStore;
    }
    
    public function findPetrolStore($hero_id)
    {
        $petrolStore =
            \DB::table($this->table)
                ->select(['hero_id', 'petrol_capacity_level', 'petrol_capacity_amount', 'petrol_amount'])
                ->find($hero_id);

        return $petrolStore;
    }
    
    public function findWaterStore($hero_id)
    {
        $petrolStore =
            \DB::table($this->table)
                ->select(['hero_id', 'water_capacity_level', 'water_capacity_amount', 'water_amount'])
                ->find($hero_id);

        return $petrolStore;
    }

    public function updateOilStore($hero_id, $capacityLevel, $capacityAmount, $oilAmount)
    {
        return
            \DB::table($this->table)
                ->where('hero_id', $hero_id)
                ->update([
                    'oil_capacity_level' => $capacityLevel,
                    'oil_capacity_amount' => $capacityAmount,
                    'oil_amount' => $oilAmount,
                ]);
    }

    public function updatePetrolStore($hero_id, $capacityLevel, $capacityAmount, $petrolAmount)
    {
        return
            \DB::table($this->table)
                ->where('hero_id', $hero_id)
                ->update([
                    'petrol_capacity_level' => $capacityLevel,
                    'petrol_capacity_amount' => $capacityAmount,
                    'petrol_amount' => $petrolAmount,
                ]);
    }
}
