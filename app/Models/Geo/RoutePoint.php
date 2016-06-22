<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class RoutePoint extends Model
{
    protected $table      = 'geo_travel_route_points';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['location_id', 'status', 'number', 'route_id'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
