<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class TravelShip extends Model
{
    protected $table      = 'geo_travel_ships';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['destination_location_id', 'date_sending'];

    public function destination()
    {
        return $this->belongsTo(Location::class, 'destination_location_id', 'id');
    }
}
