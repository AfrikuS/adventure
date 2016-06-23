<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class LiveVoyage extends Model
{
    protected $table      = 'geo_travel_live_voyages';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['location_id', 'status', 'traveler_id'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
