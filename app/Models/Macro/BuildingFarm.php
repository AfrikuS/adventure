<?php

namespace App\Models\Macro;

use Illuminate\Database\Eloquent\Model;

class BuildingFarm extends Model
{
    protected $table      = 'macro_buildings_farms';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    public function building()
    {
        return $this->morphOne('App\Models\Macro\Building', 'concrete', 'kind', 'concrete_building_id');
    }
}
