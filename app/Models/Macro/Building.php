<?php

namespace App\Models\Macro;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table      = 'macro_buildings';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    //        https://webdevtuts.co.uk/polymorphic-relationships-in-laravel/

    public function ownerUser()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function concrete()
    {
        return $this->morphTo(null, 'kind', 'concrete_building_id');
    }

    public function hasConcrete() {
        return $this->concrete != null;
    }
}
