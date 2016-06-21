<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AuctionLot extends Model
{
    protected $table      = 'auction_lot';
    public    $timestamps = false;
    protected $fillable   = ['*'];

    public function thing() // todo check
    {
        return $this->hasOne('App\Models\HeroThing', 'id', 'thing_id');
    }
}
