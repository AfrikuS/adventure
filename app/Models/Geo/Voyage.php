<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    protected $table      = 'geo_travel_voyages';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['route_id', 'point_id', 'status'];

    public function route()
    {
        return $this->belongsTo(TravelRoute::class, 'route_id', 'id');

    }

    public function point()
    {
        return $this->belongsTo(RoutePoint::class, 'point_id', 'id');
    }
}
