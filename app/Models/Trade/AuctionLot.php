<?php

namespace App\Models\Trade;

use App\Models\Core\Thing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AuctionLot extends Model
{
    protected $table      = 'auction_lot';
    public    $timestamps = false;
    protected $fillable   = ['owner_id', 'owner_user_name',
            'thing_id', 'thing_title', 'title', 'bid', 'purchaser_id', 'date_time'];

    public function thing()
    {
        return $this->hasOne(Thing::class, 'id', 'thing_id');
    }
}
