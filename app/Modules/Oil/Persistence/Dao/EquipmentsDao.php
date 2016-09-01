<?php

namespace App\Modules\Oil\Persistence\Dao;

class EquipmentsDao
{
    protected $table = 'hero_equipment';

    public function create($hero_id, $pumpLevel, $oilDistillatorLevel)
    {
            \DB::table($this->table)->insert([
                'hero_id' => $hero_id,
                'pump_level' => $pumpLevel,
                'oil_distillator_level' => $oilDistillatorLevel,
            ]);
    }

    public function find($hero_id)
    {
        $equipments =
            \DB::table($this->table)
                ->select(['hero_id', 'pump_level', 'oil_distillator_level'])
                ->find($hero_id);

        return $equipments;
    }
}
