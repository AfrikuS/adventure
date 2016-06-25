<?php

namespace App\Models\Trade;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AuctionLot extends Model
{
    protected $table      = 'auction_lot';
    public    $timestamps = false;
    protected $fillable   = ['*'];

    public function thing() // todo check
    {
        return $this->hasOne(Thing::class, 'id', 'thing_id');
    }
}
