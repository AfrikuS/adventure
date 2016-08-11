<?php

namespace App\Models\Trade;

use Illuminate\Database\Eloquent\Model;

class LazyTrade extends Model
{
    protected $table      = 'trade_lazy_trades';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['hero_id', 'resource_code', 'resource_amount', 'resource_price'];
}
