<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class LocationPath extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'geo_location_paths';
    public $timestamps = false;
    public $fillable = ['from_id', 'to_id'];

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_id', 'id');
    }
}
