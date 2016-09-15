<?php

namespace App\Modules\Oil\Persistence\Dao;

class EquipmentsDao
{
    protected $table = 'hero_equipment';

    public function create($hero_id, $pumpLevel, $oilDistillerLevel)
    {
        \DB::table($this->table)->insert([
            'hero_id' => $hero_id,
            'pump_level' => $pumpLevel,
            'oil_distillator_level' => $oilDistillerLevel,
        ]);
    }

    /** @deprecated  */
    public function find($hero_id)
    {
        $equipments =
            \DB::table($this->table)
                ->select(['hero_id', 'pump_level', 'oil_distillator_level'])
                ->find($hero_id);

        return $equipments;
    }

    public function findOilPumpBy($hero_id)
    {
        $pump =
            \DB::table($this->table)
                ->select(['hero_id', 'pump_level AS level'])
                ->where('hero_id', $hero_id)
                ->first();

        return $pump;
    }

    public function updatePump($hero_id, $level)
    {
        \DB::table($this->table)
            ->where('hero_id', $hero_id)
            ->update([
                'pump_level' => $level,
            ]);
    }

    public function findOilDistillerBy($hero_id)
    {
        return
            \DB::table($this->table)
                ->select(['hero_id', 'oil_distillator_level AS level'])
                ->where('hero_id', $hero_id)
                ->first();
    }

    public function updateDistiller($hero_id, $level)
    {
        return
            \DB::table($this->table)
                ->where('hero_id', $hero_id)
                ->update([
                    'oil_distillator_level' => $level,
            ]);
    }
}
