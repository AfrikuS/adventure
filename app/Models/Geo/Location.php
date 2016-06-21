<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
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
        return $this->belongsToMany('App\Models\Geo\Location', 'geo_locations_rels',
            'from_id', 'to_id');
    }

    public function locationsFrom() {
        return $this->belongsToMany('App\Models\Geo\Location', 'geo_locations_rels',
            'to_id', 'from_id');
    }

}
