<?php

namespace App\Models\Trade;

use Illuminate\Database\Eloquent\Model;

class TradePrice extends Model
{
    protected $table      = 'trade_resources_prices';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['id', 'resource_code', 'railway_price', 'sea_price']; 
}


