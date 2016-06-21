<?php

namespace App\Models\Sea;

use Illuminate\Database\Eloquent\Model;

class TravelShip extends Model
{
    protected $table      = 'sea_travel_ships';
    public    $timestamps = false;
    protected $fillable   = ['destination', 'resource_code', 'date_sending'];


}
