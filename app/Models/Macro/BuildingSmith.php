<?php

namespace App\Models\Macro;

use Illuminate\Database\Eloquent\Model;

class BuildingSmith extends Model
{
    protected $table      = 'macro_buildings_smiths';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    public    $fillable = ['user_id', 'building_id', 'building_id', 'title', 'level'];

    public function building()
    {
        return $this->morphOne('App\Models\Macro\Building', 'concrete', 'kind', 'concrete_building_id');
    }
}
