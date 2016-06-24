<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class TravelOrder extends Model
{
    protected $table      = 'geo_travel_orders';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['traveler_id', 'ship_id', 'type', 'total_amount'];
}
