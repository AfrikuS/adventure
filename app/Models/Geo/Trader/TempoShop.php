<?php

namespace App\Models\Geo\Trader;

use App\Models\Geo\Trader;
use Illuminate\Database\Eloquent\Model;

class TempoShop extends Model
{
    protected $table      = 'geo_trader_temporary_shops';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['owner_id', 'date_ending', 'status'];

    public function owner()
    {
        return $this->belongsTo(Trader::class, 'owner_id', 'id');
    }
}
