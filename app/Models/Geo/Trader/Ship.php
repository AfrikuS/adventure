<?php

namespace App\Models\Geo\Trader;

use App\Models\Geo\Trader;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $table      = 'geo_trader_ships';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['owner_id'];

    public function owner()
    {
        return $this->belongsTo(Trader::class, 'owner_id', 'id');
    }
}
