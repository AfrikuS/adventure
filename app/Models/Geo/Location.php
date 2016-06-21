<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'geo_locations';
    public $timestamps = false;
    public $fillable = ['title'];


//    public static function addPrevLocation(Location $srcLocation, $title) {
//        $loc = new static ($title);
//        $srcLocation->locationsFrom()->attach($loc);
//    }

//    public static function addNextLocation(Location $srcLocation, Location $destLocation) {
//        $srcLocation->locationsTo()->attach($destLocation);
//    }

    public function locationsTo() {
        return $this->belongsToMany(Location::class, 'geo_location_paths',
            'from_id', 'to_id');
    }

    public function locationsFrom() {
        return $this->belongsToMany(Location::class, 'geo_location_paths',
            'to_id', 'from_id');
    }
}
