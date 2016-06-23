<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class TravelRoute extends Model
{
    protected $table      = 'geo_travel_routes';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['title', 'user_id'];

    public function points()
    {
        return $this->hasMany(RoutePoint::class, 'route_id', 'id');
    }
}
