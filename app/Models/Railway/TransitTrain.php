<?php

namespace App\Models\Railway;

use App\Models\Npc\Character;
use Illuminate\Database\Eloquent\Model;

class TransitTrain extends Model
{
    protected $table      = 'railway_transit_trains';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['conductor_id', 'kind', 'status', 'start_time', 'end_time'];

    public function conductor()
    {
        return $this->belongsTo(Character::class, 'conductor_id');
    }
}
