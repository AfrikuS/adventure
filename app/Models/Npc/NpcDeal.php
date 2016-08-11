<?php

namespace App\Models\Npc;

use App\Models\Core\Hero;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class NpcDeal extends Model
{
    protected $table      = 'npc_deals';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['hero_id', 'npc_char', 'task', 'reward',   
                             'offer_status', 'offer_ending', 'deal_status', 'deal_ending'];

    public function hero()
    {
        return $this->belongsTo(Hero::class, 'hero_id', 'id');
    }

    public function isOfferExpired()
    {
        return Carbon::parse($this->offer_ending)->isPast();
    }

    public function isDealExpired()
    {
        return Carbon::parse($this->deal_ending)->isPast();
    }
}
