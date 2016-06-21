<?php

namespace App\Models\Sea;

use Illuminate\Database\Eloquent\Model;

class TravelOrder extends Model
{
    protected $table      = 'sea_travel_orders';
    public    $timestamps = false;
    protected $fillable   = ['destination', 'resource_code', 'date_time', 'user_id', 'travel_id'];
}
